document.rea
//TOAST
const myToast = document.querySelector('.myToast'),
    openToast = document.querySelector('.openToast'),
    myToastClose = document.querySelector('.close'),
    progressbarToast = document.querySelector('.progressbar-myToast')
;
openToast.addEventListener('click',()=>{
    myToast.classList.add('active');
    progressbarToast.classList.add('active');

    setTimeout(()=>{
        myToast.classList.remove("active")
    },60000);
    setTimeout(()=>{
        progressbarToast.classList.remove('active');
    },60000);
});
myToastClose.addEventListener('click',()=>{
    myToast.classList.remove('active');

    setTimeout(()=>{
        progressbarToast.classList.remove('active');
    },60000);
});