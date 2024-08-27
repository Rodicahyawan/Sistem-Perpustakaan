function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Example functions to open modals
function addBook() {
    openModal('addBookModal');
}

function addMember() {
    openModal('addMemberModal');
}

function addLoan() {
    openModal('addLoanModal');
}

function addReturn() {
    openModal('addReturnModal');
}

// Close the modals when the user clicks outside of the modal content
window.onclick = function(event) {
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
}
