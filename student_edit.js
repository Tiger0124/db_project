// 頁面載入完成後初始化
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    initializeFormValidation();
});

// 初始化標籤切換功能
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const memberForms = document.querySelectorAll('.member-form');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetMember = this.getAttribute('data-member');
            
            // 移除所有按鈕的active狀態
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            // 隱藏所有表單
            memberForms.forEach(form => {
                form.classList.remove('active');
                form.style.display = 'none';
            });
            
            // 激活當前按鈕
            this.classList.add('active');
            
            // 顯示對應的表單
            const targetForm = document.querySelector(`[data-form="${targetMember}"]`);
            if (targetForm) {
                targetForm.style.display = 'block';
                setTimeout(() => {
                    targetForm.classList.add('active');
                }, 10);
            }
        });
    });
    
    // 初始化顯示第一個表單
    if (tabButtons.length > 0 && memberForms.length > 0) {
        const firstButton = tabButtons[0];
        const firstForm = memberForms[0];
        
        firstButton.classList.add('active');
        firstForm.style.display = 'block';
        setTimeout(() => {
            firstForm.classList.add('active');
        }, 10);
    }
}

// 初始化表單驗證
function initializeFormValidation() {
    const form = document.getElementById('editForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // 為所有輸入框添加即時驗證
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', validateInput);
        input.addEventListener('input', clearInputError);
    });
}

// 驗證單個輸入框
function validateInput(event) {
    const input = event.target;
    const value = input.value.trim();
    
    // 移除之前的錯誤樣式
    clearInputError(event);
    
    if (!value) {
        showInputError(input, '此欄位為必填');
        return false;
    }
    
    // 特殊驗證
    switch (input.type) {
        case 'email':
            if (!isValidEmail(value)) {
                showInputError(input, '請輸入有效的電子郵件格式');
                return false;
            }
            break;
        case 'tel':
            if (!isValidPhone(value)) {
                showInputError(input, '請輸入有效的電話號碼');
                return false;
            }
            break;
        case 'number':
            const num = parseInt(value);
            if (isNaN(num) || num < 1 || num > 4) {
                showInputError(input, '年級必須在1-4之間');
                return false;
            }
            break;
    }
    
    // 身分證字號驗證
    if (input.name.includes('_id') && !isValidTaiwanID(value)) {
        showInputError(input, '請輸入有效的身分證字號格式');
        return false;
    }
    
    return true;
}

// 清除輸入框錯誤
function clearInputError(event) {
    const input = event.target;
    input.classList.remove('error');
    
    const errorMsg = input.parentNode.querySelector('.error-message');
    if (errorMsg) {
        errorMsg.remove();
    }
}

// 顯示輸入框錯誤
function showInputError(input, message) {
    input.classList.add('error');
    
    // 移除舊的錯誤訊息
    const oldError = input.parentNode.querySelector('.error-message');
    if (oldError) {
        oldError.remove();
    }
    
    // 添加新的錯誤訊息
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    
    input.parentNode.appendChild(errorDiv);
}

// 驗證整個表單
function validateForm() {
    const form = document.getElementById('editForm');
    const requiredInputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    requiredInputs.forEach(input => {
        // 只驗證當前顯示的表單中的輸入框
        const memberForm = input.closest('.member-form');
        if (memberForm && !memberForm.classList.contains('active')) {
            return; // 跳過隱藏的表單
        }
        
        const event = { target: input };
        if (!validateInput(event)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        showNotification('請修正表單中的錯誤後再提交', 'error');
    }
    
    return isValid;
}

// 驗證電子郵件格式
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// 驗證電話號碼格式
function isValidPhone(phone) {
    const phoneRegex = /^[\d\-\(\)\+\s]{8,15}$/;
    return phoneRegex.test(phone);
}

// 驗證台灣身分證字號格式
function isValidTaiwanID(id) {
    const idRegex = /^[A-Z][12]\d{8}$/;
    if (!idRegex.test(id)) return false;
    
    // 身分證字號檢查碼驗證
    const letters = 'ABCDEFGHJKLMNPQRSTUVXYWZIO';
    const letterValue = letters.indexOf(id[0]) + 10;
    const checkSum = Math.floor(letterValue / 10) + 
                    (letterValue % 10) * 9 + 
                    parseInt(id[1]) * 8 + 
                    parseInt(id[2]) * 7 + 
                    parseInt(id[3]) * 6 + 
                    parseInt(id[4]) * 5 + 
                    parseInt(id[5]) * 4 + 
                    parseInt(id[6]) * 3 + 
                    parseInt(id[7]) * 2 + 
                    parseInt(id[8]) * 1 + 
                    parseInt(id[9]);
    
    return checkSum % 10 === 0;
}

// 顯示通知訊息
function showNotification(message, type = 'info') {
    // 移除舊的通知
    const oldNotification = document.querySelector('.notification');
    if (oldNotification) {
        oldNotification.remove();
    }
    
    // 創建新通知
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // 設定樣式
    Object.assign(notification.style, {
        position: 'fixed',
        top: '100px',
        right: '20px',
        padding: '1rem 1.5rem',
        borderRadius: '8px',
        color: 'white',
        fontWeight: '600',
        zIndex: '9999',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease',
        maxWidth: '300px'
    });
    
    // 設定背景顏色
    switch (type) {
        case 'error':
            notification.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
            break;
        case 'success':
            notification.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
            break;
        default:
            notification.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
    }
    
    document.body.appendChild(notification);
    
    // 顯示動畫
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // 自動隱藏
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// 添加錯誤輸入框樣式
const style = document.createElement('style');
style.textContent = `
    input.error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
`;
document.head.appendChild(style);
