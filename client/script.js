// eğer #isDelete id'li butona tıklanırsa bir confirm penceresi aç eğer evet derse href değerine yönlendir
document.getElementById('isDelete').addEventListener('click', function (e) {
    e.preventDefault(); // Önce varsayılan tıklama davranışını durduruyoruz.
    let result = confirm("Bu mesajı silmek istediğinize emin misiniz?"); // Kullanıcıya onay soruyoruz.
    if (result) {
        // Eğer kullanıcı "Evet" derse, silme işlemi için linkin yönlendirdiği URL'ye gider.
        window.location.href = this.getAttribute('href');
    } else {
        // Eğer kullanıcı "Hayır" derse, herhangi bir işlem yapmayız.
    }
});