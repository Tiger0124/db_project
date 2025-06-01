// 頁面載入完成後初始化
document.addEventListener('DOMContentLoaded', function() {
    initializeResultPage();
});

// 初始化結果頁面
function initializeResultPage() {
    // 添加頁面載入動畫
    animateResultElements();
    
    // 自動跳轉功能（可選）
    // setTimeout(() => {
    //     autoRedirect();
    // }, 5000);
}

// 動畫化結果元素
function animateResultElements() {
    const resultContainer = document.querySelector('.result-container');
    const actionButtons = document.querySelector('.action-buttons');
    
    if (resultContainer) {
        resultContainer.style.opacity = '0';
        resultContainer.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            resultContainer.style.transition = 'all 0.6s ease';
            resultContainer.style.opacity = '1';
            resultContainer.style.transform = 'translateY(0)';
        }, 100);
    }
    
    if (actionButtons) {
        actionButtons.style.opacity = '0';
        actionButtons.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            actionButtons.style.transition = 'all 0.4s ease';
            actionButtons.style.opacity = '1';
            actionButtons.style.transform = 'translateY(0)';
        }, 800);
    }
}

// 自動跳轉功能（可選）
function autoRedirect() {
    const dashboardBtn = document.querySelector('.dashboard-btn');
    if (dashboardBtn) {
        showCountdown(5, () => {
            dashboardBtn.click();
        });
    }
}

// 顯示倒數計時
function showCountdown(seconds, callback) {
    const countdownDiv = document.createElement('div');
    countdownDiv.className = 'countdown-notice';
    countdownDiv.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        font-size: 1.1rem;
        z-index: 9999;
        text-align: center;
    `;
    
    document.body.appendChild(countdownDiv);
    
    const updateCountdown = () => {
        countdownDiv.textContent = `${seconds} 秒後自動返回主頁...`;
        
        if (seconds <= 0) {
            countdownDiv.remove();
            callback();
            return;
        }
        
        seconds--;
        setTimeout(updateCountdown, 1000);
    };
    
    updateCountdown();
    
    // 點擊取消自動跳轉
    countdownDiv.addEventListener('click', () => {
        countdownDiv.remove();
    });
}
