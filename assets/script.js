// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
    
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Modal functionality
    const modals = document.querySelectorAll('.modal');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const openModalButtons = document.querySelectorAll('[data-modal]');
    
    // Open modal
    openModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
            }
        });
    });
    
    // Close modal
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.classList.remove('active');
            }
        });
    });
    
    // Close modal when clicking outside
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
    
    // Filter functionality for admin pages
    const categoryFilter = document.getElementById('categoryFilter');
    const companyFilter = document.getElementById('companyFilter');
    const typeFilter = document.getElementById('typeFilter');
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterItems);
    }
    if (companyFilter) {
        companyFilter.addEventListener('change', filterItems);
    }
    if (typeFilter) {
        typeFilter.addEventListener('change', filterItems);
    }
    
    function filterItems() {
        const selectedCategory = categoryFilter ? categoryFilter.value : '';
        const selectedCompany = companyFilter ? companyFilter.value : '';
        const selectedType = typeFilter ? typeFilter.value : '';
        
        if (document.querySelector('.events-grid.admin')) {
            // Filter events
            document.querySelectorAll('.event-card.admin').forEach(card => {
                const categoryId = card.getAttribute('data-category');
                const show = (!selectedCategory || categoryId === selectedCategory);
                card.style.display = show ? 'block' : 'none';
            });
        }
        
        if (document.querySelector('.jobs-list.admin')) {
            // Filter jobs
            document.querySelectorAll('.jobs-list.admin tbody tr').forEach(row => {
                const companyId = row.getAttribute('data-company');
                const jobType = row.getAttribute('data-type');
                const showCompany = (!selectedCompany || companyId === selectedCompany);
                const showType = (!selectedType || jobType === selectedType);
                row.style.display = (showCompany && showType) ? '' : 'none';
            });
        }
    }
    
    // Feedback modal for announcements
    const feedbackButtons = document.querySelectorAll('.btn-feedback');
    const feedbackModal = document.getElementById('feedbackModal');
    
    if (feedbackButtons.length && feedbackModal) {
        feedbackButtons.forEach(button => {
            button.addEventListener('click', function() {
                const announcementId = this.getAttribute('data-announcement-id');
                const announcementTitle = this.getAttribute('data-announcement-title');
                
                document.getElementById('feedbackAnnouncementId').value = announcementId;
                document.getElementById('feedbackMessage').placeholder = 
                    `Feedback regarding: ${announcementTitle}\n\n`;
                
                feedbackModal.classList.add('active');
            });
        });
    }
    
    // Feedback form submission
    const feedbackForm = document.getElementById('feedbackForm');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Submit via AJAX (simplified - in real app, use fetch API)
            alert('Feedback submitted! In a real application, this would send the data to the server.');
            feedbackModal.classList.remove('active');
            this.reset();
        });
    }
    
    // Reply modal for feedback
    const replyButtons = document.querySelectorAll('.btn-reply');
    const replyModal = document.getElementById('replyModal');
    
    if (replyButtons.length && replyModal) {
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const email = this.getAttribute('data-email');
                document.getElementById('replyEmail').value = email;
                replyModal.classList.add('active');
            });
        });
    }
    
    // Form validation
    const forms = document.querySelectorAll('form[novalidate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    isValid = false;
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});