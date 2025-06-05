// 初始化函數
function initializeForm() {
    // 綁定組員按鈕事件
    const memberButtons = document.querySelectorAll('.member-btn');
    const studentForms = document.querySelectorAll('.student-info');
    
    memberButtons.forEach(button => {
        button.addEventListener('click', function() {
            const memberNumber = this.getAttribute('data-member');
            
            // 移除所有按鈕的active狀態
            memberButtons.forEach(btn => btn.classList.remove('active'));
            
            // 隱藏所有表單
            studentForms.forEach(form => {
                form.style.display = 'none';
                form.classList.remove('active');
            });
            
            // 激活當前按鈕
            this.classList.add('active');
            
            // 顯示對應的表單
            const targetForm = document.querySelector(`[data-student="${memberNumber}"]`);
            if (targetForm) {
                targetForm.style.display = 'block';
                setTimeout(() => {
                    targetForm.classList.add('active');
                }, 10);
            }
        });
    });

    // 表單提交驗證
    const form = document.getElementById('registrationForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // 檢查必填組員資料
            const requiredMembers = [1, 2, 3];
            let isValid = true;
            let missingMembers = [];
            
            requiredMembers.forEach(memberNum => {
                const memberForm = document.querySelector(`[data-student="${memberNum}"]`);
                if (memberForm) {
                    const requiredInputs = memberForm.querySelectorAll('input[required]');
                    let memberComplete = true;
                    
                    requiredInputs.forEach(input => {
                        if (!input.value.trim()) {
                            memberComplete = false;
                        }
                    });
                    
                    if (!memberComplete) {
                        missingMembers.push(`組員${memberNum}`);
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert(`請完整填寫以下必填組員資料：${missingMembers.join('、')}`);
                return false;
            }
            
            // 檢查隊伍名稱
            const teamName = document.getElementById('team-name');
            if (!teamName || !teamName.value.trim()) {
                e.preventDefault();
                alert('請填寫隊伍名稱！');
                return false;
            }
            
            // 檢查指導教授資料
            const professorInputs = document.querySelectorAll('#professor-id, #professor-name, #professor-email, #professor-phone');
            let professorComplete = true;
            
            professorInputs.forEach(input => {
                if (!input.value.trim()) {
                    professorComplete = false;
                }
            });
            
            if (!professorComplete) {
                e.preventDefault();
                alert('請完整填寫指導教授資料！');
                return false;
            }
        });
    }

    // 為組員四的輸入框添加特殊處理
    const member4Form = document.querySelector('[data-student="4"]');
    if (member4Form) {
        const member4Inputs = member4Form.querySelectorAll('input');
        
        // 監聽組員四的輸入變化
        member4Inputs.forEach(input => {
            input.addEventListener('input', function() {
                const hasAnyValue = Array.from(member4Inputs).some(inp => inp.value.trim());
                
                if (hasAnyValue) {
                    // 如果有任何一個欄位有值，則所有欄位都變為必填
                    member4Inputs.forEach(inp => inp.setAttribute('required', 'required'));
                } else {
                    // 如果所有欄位都為空，則移除必填屬性
                    member4Inputs.forEach(inp => inp.removeAttribute('required'));
                }
            });
        });
    }

    // 初始化顯示第一個組員表單
    const firstButton = document.querySelector('.member-btn[data-member="1"]');
    const firstForm = document.querySelector('[data-student="1"]');
    
    if (firstButton && firstForm) {
        firstButton.classList.add('active');
        firstForm.style.display = 'block';
        setTimeout(() => {
            firstForm.classList.add('active');
        }, 10);
    }
}

// 頁面載入完成後初始化
document.addEventListener('DOMContentLoaded', initializeForm);
