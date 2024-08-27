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

function openEditMemberModal(id, name, address, dob, phone, email, password) {
    document.getElementById('editMemberId').value = id;
    document.getElementById('editMemberName').value = name;
    document.getElementById('editMemberAddress').value = address;
    document.getElementById('editMemberDob').value = dob;
    document.getElementById('editMemberPhone').value = phone;
    document.getElementById('editMemberEmail').value = email;
    document.getElementById('editMemberPassword').value = password;

    document.getElementById('editMemberModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

// Function to open Edit Book Modal
function openEditBookModal(id_buku) {
    var modal = document.getElementById('editBookModal');
    
    // Fetch data from server
    fetch(`get_buku.php?id_buku=${id_buku}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                document.getElementById('editBookId').value = data.id_buku;
                document.getElementById('editBookTitle').value = data.judul_buku;
                document.getElementById('editBookAuthor').value = data.penulis;
                document.getElementById('editBookYear').value = data.tahun_terbit;
                document.getElementById('editBookGenre').value = data.genre;
                modal.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to close any modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Event listener for closing modals when clicking outside
window.onclick = function(event) {
    var modals = document.getElementsByClassName('modal');
    for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = 'none';
        }
    }
}

// admin.js

// Function to open the edit book modal and populate it with the book data
function openEditBookModal(id, title, author, year, genre) {
    document.getElementById('editBookId').value = id;
    document.getElementById('editBookTitle').value = title;
    document.getElementById('editBookAuthor').value = author;
    document.getElementById('editBookYear').value = year;
    document.getElementById('editBookGenre').value = genre;

    document.getElementById('editBookModal').style.display = 'block';
}

// Function to close the modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Event listener for clicks outside of the modal to close it
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

function editReturn(id_pengembalian) {
    // Ambil data dari baris tabel sesuai dengan ID Pengembalian
    const row = document.querySelector(`tr[data-id='${id_pengembalian}']`);
    const idBuku = row.querySelector('td:nth-child(2)').innerText;
    const tanggalPengembalian = row.querySelector('td:nth-child(3)').innerText;
    const denda = row.querySelector('td:nth-child(4)').innerText;
    const statusPengembalian = row.querySelector('td:nth-child(5)').innerText;

    // Set data ke dalam modal
    document.getElementById('edit-id').value = id_pengembalian;
    document.getElementById('edit-id-buku').value = idBuku;
    document.getElementById('edit-tanggal-pengembalian').value = tanggalPengembalian;
    document.getElementById('edit-denda').value = denda;
    document.getElementById('edit-status-pengembalian').value = statusPengembalian;

    // Tampilkan modal
    document.getElementById('editModal').style.display = 'block';
}

// Tutup modal saat tombol batal diklik
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('editModal').style.display = 'none';
});

