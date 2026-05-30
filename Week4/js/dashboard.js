const form = document.getElementById("productForm");

const nameInput = document.getElementById("name");
const descInput = document.getElementById("description");
const priceInput = document.getElementById("price");
const stockInput = document.getElementById("stock");
const imageInput = document.getElementById("imageInput");

const preview = document.getElementById("preview");

/* Image Preview */
setTimeout(() => {

    const popup = document.getElementById("popupAlert");

    if(popup){
        popup.style.display = "none";
    }

}, 5000);
imageInput.addEventListener("change", function(){

    const file = this.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = "block";
        }

        reader.readAsDataURL(file);
    }

});

/* Validation */

form.addEventListener("submit", function(e){

    let valid = true;

    // Clear Errors
    document.querySelectorAll(".error").forEach(error => {
        error.innerText = "";
    });

    // Name
    if(nameInput.value.trim() === ""){
        document.getElementById("nameError").innerText =
        "Product name is required";
        valid = false;
    }

    // Description
    if(descInput.value.trim() === ""){
        document.getElementById("descriptionError").innerText =
        "Description is required";
        valid = false;
    }

    // Price
    if(priceInput.value.trim() === ""){
        document.getElementById("priceError").innerText =
        "Price is required";
        valid = false;
    }

    // Stock
    if(stockInput.value.trim() === ""){
        document.getElementById("stockError").innerText =
        "Stock is required";
        valid = false;
    }

    // Image
    if(imageInput.files.length === 0){
        document.getElementById("imageError").innerText =
        "Please upload an image";
        valid = false;
    }

    if(!valid){
        e.preventDefault();
    }

});