const myPopup = document.querySelector('.popup'),
	openPopup = document.querySelector('.openPopup'),
    viderPanier = document.querySelector('.vider'),
    checkout = document.querySelector('.checkout'),
    price = document.querySelector('.price'),
    total = document.querySelectorAll('.total'),
    totals = document.querySelector('.totals'),
    totaux = document.querySelector('#totaux'),
    supprimer = document.querySelectorAll('.supprimer'),
    panierList = document.querySelector('#panierList'),
    tbody = document.querySelector('.tBody'),
    ajouterPanier = document.querySelectorAll('.ajouterPanier'),
    BASE_URI_GET = "https://localhost:8000/api/panier",
    BASE_URI_ADD = "https://localhost:8000/api/panier/add",
    BASE_URI_CLEAR = "https://localhost:8000/api/panier/clear",
    BASE_URI_DELETE = "https://localhost:8000/api/panier/delete",
    BASE_URI_CHECK0UT = "https://localhost:8000/api/panier/checkout"
;
let output = null;
let renderPanier = (panier) => {
    let t;
    $(``).prependTo(panierList);
    $(``).prependTo(output);
    let datapanier = panier.productpanier;
    let i = 1;
    let list = [];
    $.each( datapanier, function() {
        let tr = document.createElement("tr"),
            td1 = document.createElement("td"),
            div1 = document.createElement("div"),
            img1 = document.createElement("img"),
            td2 = document.createElement("td"),
            input2 = document.createElement("input"),
            td3 = document.createElement("td"),
            input3 = document.createElement("input"),
            td4 = document.createElement("td"),
            input4 = document.createElement("input"),
            td5 = document.createElement("td"),
            a5 = document.createElement("a"),
            i5 = document.createElement("i")
        ;
        tr.id="panierList";
        // td1
        div1.className = "toopart";
        div1.style.maxWidth = "3rem";
        img1.setAttribute("height","35");
        img1.setAttribute("src", `https://localhost:8000/uploads/images/${this.product.imageName}`);
        div1.appendChild(img1);
        td1.id = "D1";
        td1.appendChild(div1);
        // td2
        input2.type = "button";
        input2.value = `${this.product.price}`;
        input2.style.width = "3rem";
        input2.style.height = "2rem";
        input2.style.textAlign = "center";
        input2.className = "btn btn-small indigo lighten-3 price";
        td2.id = "D2";
        td2.appendChild(input2);
        // td3
        input3.id = `${this.product.slug}`;
        input3.setAttribute("min",1);
        input3.setAttribute("onChange","handleQuantity(this)");
        input3.type = "number";
        input3.value = `${this.quantite}`;
        input3.className = "btn btn-small indigo darken-4";
        input3.style.height = "2rem";
        input3.style.width = "3rem";
        input3.style.textAlign = "center";
        td3.id = "D3";
        td3.appendChild(input3);
        // td4
        input4.type = "button";
        input4.value = `${this.quantite*this.product.price}`;
        input4.className = "btn btn-small indigo lighten-3 total";
        input4.style.height = "2rem";
        input4.style.width = "auto";
        input4.style.textAlign = "center";
        td4.id = "D4";
        td4.appendChild(input4);
        // td5
        a5.href = "#";
        a5.id = "supprimer";
        a5.setAttribute("data-slud",`${this.product.slug}`);
        a5.className = "btn btn-floating pink darken-1 supprimer",
        i5.setAttribute("data-slug",`${this.product.slug}`)
        i5.className = "material-icons white-text";
        i5.innerHTML = "delete";
        a5.appendChild(i5);
        td5.id = "D5";
        td5.appendChild(a5);
        // tr panierList
        tr.id = 'T'+i;
        tr.appendChild(td1);
        td1.after(td2);
        td2.after(td3);
        td3.after(td4);
        td4.after(td5);
        list[i] = tr;
        i++;
    });
    output = list;
    t += `
    <tr id="totaux">
        <td colspan="2" class="totaux">Totaux</td>
        <td colspan="3" class="totaux">$
            <input style="height: 2rem;width:auto;text-align: center;" value="${panier.total}" class="btn btn-small indigo darken-3 totals" type="text"/>
        </td>
    </tr>
    `;
    $(panierList).replaceWith(output);
    $(totaux).replaceWith(t);
}
function handleQuantity(val){
    let tt = 0;
    let v = val.value;
    let slug = val.id; 
    let t  = document.querySelectorAll('.total');
    let tts = document.querySelector('.totals');
    let input2 = val.parentElement.previousElementSibling.children.item(0);
    let input4 = val.parentElement.nextElementSibling.children.item(0);
    input4.value = input2.value*v;
    t.forEach(c => {
        tt += parseFloat( c.value); 
    });
    tts.value = tt;
    try {
        let options = {
            type: 'POST',
            url: `${BASE_URI_ADD}/${slug}/${v}`,
            CORS: true ,
            contentType:'application/json',
            secure: true,
            headers: {
            'Access-Control-Allow-Origin': '*',
            },
        };
        $.ajax(options).done(function(response){
            console.log(response);
        }); 
    } catch (error) {
        console.log(`Produit_Session: ${error.message}`);
    }
    console.log(`QUANTITY = ${v}`+`SLUG=${slug}`);
}
function openNav() {
    const panier =  document.getElementById("mySidebar");
    const main = document.getElementById("main");
    panier.style.width = "32rem";
    panier.style.marginBottom = "14rem";
    main.style.marginRight = "32rem";
    panier.style.fontSize = "10vu";
    panier.style.overflowX = "scroll";
    panier.style.overflowX = "scroll";
    $(openPopup).show("fast", function() {
        $( this ).prev().show( "slow", arguments.callee );
    });
}
function closeNav() {
    $(openPopup).show("fast", function() {
        $( this ).prev().hide( "fast", arguments.callee );
    });
    document.getElementById("mySidebar").style.width = "0rem";
    document.getElementById("main").style.marginRight = "0rem";
}

$( document ).ready(function() {
    ajouterPanier.forEach(current => {
        current.addEventListener('click',(event)=>{
            event.preventDefault();
            let slug = event.target.getAttribute('data-add-slug');
            try {
                let options = {
                    url: `${BASE_URI_ADD}/${slug}`,
                    type: 'GET',
                    CORS: true ,
                    contentType:'application/json',
                    secure: true,
                    headers: {
                    'Access-Control-Allow-Origin': '*',
                    },
                };
                $.ajax(options).done(function(response){
                    location.reload();
                }); 
               
            } catch (error) {
                console.log(`PANIER-SESSION: ${error.message}`);
            }
        });
    });
    openPopup.addEventListener('click',(event)=>{
        event.preventDefault();
        openNav();
        try {
            let option = {
                url: `${BASE_URI_GET}`,
                type: 'GET',
                dataType: "json",
                CORS: true ,
                contentType:'application/json',
                secure: true,
                headers: {
                'Access-Control-Allow-Origin': '*',
                },
            };
            $.ajax(option).done(function(data){
                renderPanier(data);
                console.log(data);
            });
        } catch (error) {
            console.log(`PANIER-SESSION: ${error.message}`);
        }
    });
    viderPanier.addEventListener('click',async(event)=>{ 
        event.preventDefault();
        try {
            let options = {
                url: `${BASE_URI_CLEAR}`,
                type: 'DELETE',
                CORS: true ,
                contentType:'application/json',
                secure: true,
                headers: {
                'Access-Control-Allow-Origin': '*',
                },
            };
            $.ajax(options).done(function(response){
                console.log(response.message);
                location.reload();
            });
        } catch (error) {
            console.log(`PANIER-SESSION: ${error.message}`);
        }
    });
    checkout.addEventListener('click',(event)=>{
        event.preventDefault();
    });
    supprimer.forEach(current => {
        current.addEventListener('click', (event) =>{
            //event.preventDefault();
            console.log("Hi!!");
        });
    });
});
