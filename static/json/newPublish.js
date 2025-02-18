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
    let add = document.createElement("span");
    let schoolName = document.createElement("span");
    let typeOfSahitya = document.createElement("span");
    let publishingFees = document.createElement("span");
    let cross = document.createElement("div");

    li.setAttribute("data-id", doc.id);
    fullName.textContent = doc.data().fullName;
    age.textContent = doc.data().age;
    phone.textContent = doc.data().phone;
    email.textContent = doc.data().email;
    add.textContent = doc.data().add;
    schoolName.textContent = doc.data().schoolName;
    typeOfSahitya.textContent = doc.data().schoolName;
    publishingFees.textContent = doc.data().schoolName;
    cross.textContent = "x";

    li.appendChild(fullName);
    li.appendChild(age);
    li.appendChild(phone);
    li.appendChild(email);
    li.appendChild(add);
    li.appendChild(schoolName);
    li.appendChild(typeOfSahitya);
    li.appendChild(publishingFees);
    li.appendChild(cross);

    pickUp.appendChild(li);
}

// saving data
form.addEventListener("submit", e => {
    e.preventDefault();
    db.collection("Publish").add({
        fullName: form.fullName.value,
        age: form.age.value,
        phone: form.phone.value,
        email: form.email.value,
        add: form.add.value,
        schoolName: form.schoolName.value,
        typeOfSahitya: form.typeOfSahitya.value,
        publishingFees: form.publishingFees.value
    });
    form.fullName.value = "";
    form.age.value = "";
    form.phone.value = "";
    form.email.value = "";
    form.add.value = "";
    form.schoolName.value = "";
    form.typeOfSahitya.value = "";
    form.publishingFees.value = "";

    alert("तुमचे आवेदन यशस्वीरित्या जतन केले आहे.");
    window.location.replace("notify.html");
});


$(document).ready(function () {

    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['वयोगट ५ - १८ वर्षे', 1260],
           
            
            ['वयोगट १९ - ६० वर्षे', 383],
            ['वयोगट ६० वर्षांहून मोठे', 182]
        ]);

        var options = {
            title: 'वयोगटानुसार उमेदवारांचा सहभाग....',
            is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart3d'));

        chart.draw(data, options);
    }


});