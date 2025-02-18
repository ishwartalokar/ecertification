// Initialize Firebase
var config = {
    apiKey: "AIzaSyBgPpGBvEXbIXHJ9SomP-Y54Lk4cfr3MwY",
    authDomain: "contactformpickup.firebaseapp.com",
    databaseURL: "https://contactformpickup.firebaseio.com",
    projectId: "contactformpickup",
    storageBucket: "contactformpickup.appspot.com",
    messagingSenderId: "444357694326",
    appId: "1:444357694326:web:9b09f26b63d3b8871e2057"
};
firebase.initializeApp(config);
const db = firebase.firestore();
db.settings({ timestampsInSnapshots: true });


const pickUp = document.querySelector("#publishFormDetails");
const form = document.querySelector("#new-publish-form");

// Create An element & PublishYourSahitya
function newPublishForm(doc) {
    let li = document.createElement("li");
    let fullName = document.createElement("span");
    let age = document.createElement("span");
    let email = document.createElement("span");
    let phone = document.createElement("span");
    let city = document.createElement("span");
    let state = document.createElement("span");
    let zip = document.createElement("span");
    let examName = document.createElement("span");
    let examFees = document.createElement("span");
    let examTechnique = document.createElement("span");
    let applicationStatus = document.createElement("span");
    let cross = document.createElement("div");

    li.setAttribute("data-id", doc.id);
    fullName.textContent = doc.data().fullName;
    age.textContent = doc.data().age;
    phone.textContent = doc.data().phone;
    email.textContent = doc.data().email;
    city.textContent = doc.data().city;
    state.textContent = doc.data().state;
    zip.textContent = doc.data().zip;
    examName.textContent = doc.data().examName;
    examFees.textContent = doc.data().examFees;
    examTechnique.textContent = doc.data().examTechnique;
    applicationStatus.textContent = doc.data().applicationStatus;
    cross.textContent = "x";

    li.appendChild(fullName);
    li.appendChild(age);
    li.appendChild(phone);
    li.appendChild(email);
    li.appendChild(city);
    li.appendChild(state);
    li.appendChild(zip);
    li.appendChild(examName);
    li.appendChild(examFees);
    li.appendChild(examTechnique);
    li.appendChild(applicationStatus);
    li.appendChild(cross);

    pickUp.appendChild(li);
}

// saving data
form.addEventListener("submit", e => {
    e.preventDefault();
    db.collection("Essay_Competations_Applications").add({
        fullName: form.fullName.value,
        age: form.age.value,
        phone: form.phone.value,
        email: form.email.value,
        city: form.city.value,
        state: form.state.value,
        zip: form.zip.value,
        examName: form.examName.value,
        examFees: form.examFees.value,
        examTechnique: form.examTechnique.value,
        applicationStatus: form.applicationStatus.value
    });
    form.fullName.value = "";
    form.age.value = "";
    form.phone.value = "";
    form.email.value = "";
    form.city.value = "";
    form.state.value = "";
    form.zip.value = "";
    form.examName.value = "";
    form.examFees.value = "";
    form.examTechnique.value = "";
    form.applicationStatus.value = "";

    alert("तुमचे आवेदन यशस्वीरित्या जतन केले आहे. तुमचा वापरकर्ता आयडी व पासवर्ड तुमच्या नोंदणीकृत ई-मेल वर पाठवण्यात आला आहे.");
    window.location.replace("successful.html");
    
});