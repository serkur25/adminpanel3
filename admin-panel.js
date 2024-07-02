let currentOyunPage = 1;
let currentHaberPage = 1;
const itemsPerPage = 10;

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('newOyunForm').addEventListener('submit', handleNewOyunFormSubmit);
    document.getElementById('newHaberForm').addEventListener('submit', handleNewHaberFormSubmit);
    document.getElementById('editOyunForm').addEventListener('submit', handleEditOyunFormSubmit);
    document.getElementById('editHaberForm').addEventListener('submit', handleEditHaberFormSubmit);
    openTab(null, 'Oyunlar'); // Varsayılan olarak Oyunlar sekmesini aç
});

function openTab(event, tabName) {
    const tabcontent = document.getElementsByClassName('tabcontent');
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = 'none';
    }
    const tablinks = document.getElementsByClassName('list-group-item');
    for (let i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(' active', '');
    }
    document.getElementById(tabName).style.display = 'block';
    if (event) {
        event.currentTarget.className += ' active';
    }
    if (tabName === 'Oyunlar') {
        loadOyunlar();
    } else if (tabName === 'Haberler') {
        loadHaberler();
    }
}

function loadOyunlar() {
    fetch('oyunlar.php')
        .then(response => response.json())
        .then(data => {
            paginateData(data, 'oyun');
        })
        .catch(error => console.error('Error:', error));
}

function loadHaberler() {
    fetch('haberler.php')
        .then(response => response.json())
        .then(data => {
            paginateData(data, 'haber');
        })
        .catch(error => console.error('Error:', error));
}

function paginateData(data, type) {
    const pageCount = Math.ceil(data.length / itemsPerPage);
    const pagination = document.getElementById(type === 'oyun' ? 'oyunPagination' : 'haberPagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= pageCount; i++) {
        const pageItem = document.createElement('li');
        pageItem.className = 'page-item';
        const pageLink = document.createElement('a');
        pageLink.className = 'page-link';
        pageLink.href = '#';
        pageLink.textContent = i;
        pageLink.onclick = () => {
            if (type === 'oyun') {
                currentOyunPage = i;
                displayPageData(data, i, type);
            } else {
                currentHaberPage = i;
                displayPageData(data, i, type);
            }
        };
        pageItem.appendChild(pageLink);
        pagination.appendChild(pageItem);
    }

    displayPageData(data, type === 'oyun' ? currentOyunPage : currentHaberPage, type);
}

function displayPageData(data, page, type) {
    const list = document.getElementById(type === 'oyun' ? 'oyunlarListesi' : 'haberlerListesi');
    list.innerHTML = '';
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = data.slice(start, end);

    paginatedItems.forEach(item => {
        const listItem = createListItem(item, type);
        list.appendChild(listItem);
    });
}

function createListItem(data, type) {
    const item = document.createElement('div');
    item.className = 'table-item';

    const img = document.createElement('img');
    img.src = type === 'oyun' ? data.resim_url : data.gorsel_url;
    item.appendChild(img);

    const details = document.createElement('div');
    details.className = 'table-item-details';

    const title = document.createElement('div');
    title.className = 'table-item-title';
    title.textContent = data.baslik;
    details.appendChild(title);

    const description = document.createElement('div');
    description.className = 'table-item-description';
    description.textContent = `${data.aciklama.split(' ').slice(0, 30).join(' ')}...`;
    details.appendChild(description);

    item.appendChild(details);

    const actions = document.createElement('div');
    actions.className = 'actions';

    const editBtn = document.createElement('button');
    editBtn.textContent = 'Düzenle';
    editBtn.className = 'edit-btn';
    editBtn.onclick = () => type === 'oyun' ? openEditOyunForm(data) : openEditHaberForm(data);
    actions.appendChild(editBtn);

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Sil';
    deleteBtn.className = 'delete-btn';
    deleteBtn.onclick = () => type === 'oyun' ? deleteOyun(data.id) : deleteHaber(data.id);
    actions.appendChild(deleteBtn);

    item.appendChild(actions);

    return item;
}

function handleNewOyunFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.set('aciklama', CKEDITOR.instances.newOyunAciklama.getData());
    formData.set('detayli_aciklama', CKEDITOR.instances.newOyunDetayliAciklama.getData());
    fetch('ekle_oyun.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#newOyunModal').modal('hide');
                loadOyunlar();
                alert('Başarılı bir şekilde eklendi.');
                event.target.reset();
                CKEDITOR.instances.newOyunAciklama.setData('');
                CKEDITOR.instances.newOyunDetayliAciklama.setData('');
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => console.error('Error:', error));
}

function handleNewHaberFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.set('aciklama', CKEDITOR.instances.newHaberAciklama.getData());
    fetch('ekle_haber.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#newHaberModal').modal('hide');
                loadHaberler();
                alert('Başarılı bir şekilde eklendi.');
                event.target.reset();
                CKEDITOR.instances.newHaberAciklama.setData('');
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => console.error('Error:', error));
}

function handleEditOyunFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.set('aciklama', CKEDITOR.instances.editOyunAciklama.getData());
    formData.set('detayli_aciklama', CKEDITOR.instances.editOyunDetayliAciklama.getData());
    fetch('guncelle_oyun.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#editOyunModal').modal('hide');
                loadOyunlar();
                alert('Başarılı bir şekilde güncellendi.');
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => console.error('Error:', error));
}

function handleEditHaberFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.set('aciklama', CKEDITOR.instances.editHaberAciklama.getData());
    fetch('guncelle_haber.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#editHaberModal').modal('hide');
                loadHaberler();
                alert('Başarılı bir şekilde güncellendi.');
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => console.error('Error:', error));
}

function openEditOyunForm(oyun) {
    $('#editOyunModal').modal('show');
    document.getElementById('editOyunId').value = oyun.id;
    document.getElementById('editOyunResim').src = oyun.resim_url;
    document.getElementById('editOyunBaslik').value = oyun.baslik;
    CKEDITOR.instances.editOyunAciklama.setData(oyun.aciklama);
    CKEDITOR.instances.editOyunDetayliAciklama.setData(oyun.detayli_aciklama);
    document.getElementById('editOyunTur').value = oyun.tur;
}

function openEditHaberForm(haber) {
    $('#editHaberModal').modal('show');
    document.getElementById('editHaberId').value = haber.id;
    document.getElementById('editHaberGorsel').src = haber.gorsel_url;
    document.getElementById('editHaberBaslik').value = haber.baslik;
    CKEDITOR.instances.editHaberAciklama.setData(haber.aciklama);
}

function deleteOyun(id) {
    if (confirm('Bu oyunu silmek istediğinize emin misiniz?')) {
        fetch('sil_oyun.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadOyunlar();
                } else {
                    alert(data.message || 'Bir hata oluştu.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function deleteHaber(id) {
    if (confirm('Bu haberi silmek istediğinize emin misiniz?')) {
        fetch('sil_haber.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadHaberler();
                } else {
                    alert(data.message || 'Bir hata oluştu.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function openNewOyunForm() {
    $('#newOyunModal').modal('show');
}

function openNewHaberForm() {
    $('#newHaberModal').modal('show');
}
