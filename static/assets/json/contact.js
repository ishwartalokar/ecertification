// Initialize Firebase
var config = {
    apiKey: "AIzaSyBySVxT18MX5RvYDSqtpW8kTWzIV0OQPy8",
    authDomain: "dnyanchakshus.firebaseapp.com",
    projectId: "dnyanchakshus",
    storageBucket: "dnyanchakshus.appspot.com",
    messagingSenderId: "968406456626",
    appId: "1:968406456626:web:52ec0c3d7209b13ae8df2b",
    measurementId: "G-E51M115BZ8"
};
firebase.initializeApp(config);
const db = firebase.firestore();
db.settings({ timestampsInSnapshots: true });


const pickUp = document.querySelector("#pick-up-details");
const form = document.querySelector("#pick-up-form");




// create element & register form
function pickupForm(doc) {
    let li = document.createElement("li");
    let fullName = document.createElement("span");
    let email = document.createElement("span");
    let phone = document.createElement("span");
    let add = document.createElement("span");
    let message = document.createElement("span");
    let cross = document.createElement("div");

    li.setAttribute("data-id", doc.id);
    fullName.textContent = doc.data().fullName;
    phone.textContent = doc.data().phone;
    email.textContent = doc.data().email;
    add.textContent = doc.data().add;
    message.textContent = doc.data().message;
    cross.textContent = "x";

    li.appendChild(fullName);
    li.appendChild(phone);
    li.appendChild(email);
    li.appendChild(add);
    li.appendChild(message);
    li.appendChild(cross);

    pickUp.appendChild(li);

}

// saving data
form.addEventListener("submit", e => {
    e.preventDefault();
    db.collection("Register_Person").add({
        fullName: form.fullName.value,
        phone: form.phone.value,
        email: form.email.value,
        add: form.add.value,
        message: form.message.value
    });
    form.fullName.value = "";
    form.phone.value = "";
    form.email.value = "";
    form.add.value = "";
    form.message.value = "";

    $('.success-message').show();

    $('#pick-up-form')[0].reset();  
});