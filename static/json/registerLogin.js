$(document).ready(function(){
  //initialize the firebase app
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

  //create firebase references
  var Auth = firebase.auth(); 
  var dbRef = firebase.database();
  var contactsRef = dbRef.ref('candidateApplications')
  var usersRef = dbRef.ref('users')
  var auth = null;

  //Register
  $('#registerForm').on('submit', function (e) {
    e.preventDefault();
    $('#registerModal').modal('hide');
    $('#messageModalLabel').html(spanText('<i class="fa fa-cog fa-spin"></i>', ['center', 'info']));
    $('#messageModal').modal('show');
    var data = {
      email: $('#registerEmail').val(), //get the email from Form
      firstName: $('#registerFirstName').val(), // get firstName
        lastName: $('#registerLastName').val(), // get lastName

    };
    var passwords = {
      password : $('#registerPassword').val(), //get the pass from Form
      cPassword : $('#registerConfirmPassword').val(), //get the confirmPass from Form
    }
    if( data.email != '' && passwords.password != ''  && passwords.cPassword != '' ){
      if( passwords.password == passwords.cPassword ){
        //create the user
        
        firebase.auth()
          .createUserWithEmailAndPassword(data.email, passwords.password)
          .then(function(user) {
            return user.updateProfile({
              displayName: data.firstName + ' ' + data.lastName
            })
          })
          .then(function(user){
            //now user is needed to be logged in to save data
            auth = user;
            //now saving the profile data
            usersRef.child(user.uid).set(data)
              .then(function(){
                console.log("User Information Saved:", user.uid);
              })
            $('#messageModalLabel').html(spanText('Success!', ['center', 'success']))
            
            $('#messageModal').modal('hide');
          })
          .catch(function(error){
            console.log("Error creating user:", error);
            $('#messageModalLabel').html(spanText('ERROR: '+error.code, ['danger']))
          });
      } else {
        //password and confirm password didn't match
          $('#messageModalLabel').html(spanText("ERROR: संकेतशब्द जुळत नाहीत", ['danger']))
      }
    }  
  });

  //Login
  $('#loginForm').on('submit', function (e) {
    e.preventDefault();
    $('#loginModal').modal('hide');
    $('#messageModalLabel').html(spanText('<i class="fa fa-cog fa-spin"></i>', ['center', 'info']));
    $('#messageModal').modal('show');

    if( $('#loginEmail').val() != '' && $('#loginPassword').val() != '' ){
      //login the user
      var data = {
        email: $('#loginEmail').val(),
        password: $('#loginPassword').val()
      };
      firebase.auth().signInWithEmailAndPassword(data.email, data.password)
        .then(function(authData) {
          auth = authData;
            $('#messageModalLabel').html(spanText('यशस्वी!', ['center', 'success']))
            $('#messageModal').modal('hide');
            $('#addContactModal').modal('show');
        })
        .catch(function(error) {
            console.log("लॉगिन अयशस्वी!", error);
          $('#messageModalLabel').html(spanText('ERROR: '+error.code, ['danger']))
        });
    }
  });

  $('#logout').on('click', function(e) {
    e.preventDefault();
    firebase.auth().signOut()
  });

  //save contact
  $('#contactForm').on('submit', function( event ) {  
    event.preventDefault();
    if( auth != null ){
      if( $('#name').val() != '' || $('#email').val() != '' ){
        contactsRef.child(auth.uid)
            .push({
                makepayment: "Donate Us",
                feeslink: "https://rzp.io/l/lakshya3r-donation",
            name: $('#name').val(),
              email: $('#email').val(),
              phone: $('#phone').val(),
              imageStatus: $('#imageUploadStatus').val(),
              url: $('#fileButton').val(''),
              application: $('#applicationStatus').val(),
              age: $('#age').val(),
              exam: $('#examName').val(),
              fees: $('#examFees').val(),
              method: $('#examTechnique').val(),


             
            location: {
              city: $('#city').val(),
              state: $('#state').val(),
                zip: $('#zip').val(),
                
               
            }
          })
          $('#addContactModal').modal('hide');
          alert('तुमचे आवेदन यशस्वीरित्या जतन केले आहे. खाली दिलेल्या OK बटणावर क्लिक करा.');
      } else {
        alert('Please fill at-lease name or email!');
      }
    } else {
      //inform user to login
    }
  });

    
    var uploader = document.getElementById('uploader'),
        fileButton = document.getElementById('fileButton');

    fileButton.addEventListener('change', function (e) {
        var file = e.target.files[0];
        var storageRef = firebase.storage().ref("'images/'" + auth.uid);
        var task = storageRef.put(file);

        task.on('state_changed',

            function progress(snapshot) {
                var percentage = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                uploader.value = percentage;
                if (percentage == 100) {
                    alert("file uploaded Successfully");
                }
            },
            function error(err) {

            },
            function complete() {

                var downloadURL = task.snapshot.downloadURL;
                var postkey = firebase.database().ref('candidateApplications/' + auth.uid).push();
               
                postkey.child("url").set(downloadURL)

                $('.success-message').show();
                

                $("#applinewDisbled").hide();
            });
       

    }


    );


    /**
    function onChildAdd(snap) {
        $('#profileImage').append(proimageHtmlFromObject(snap.urlid, snap.val()));
    }



    function proimageHtmlFromObject(urlid, proimage) {
        return '<div id="' + urlid + '">'

            + '<div class="candidateImagDiv">'

            + '<img  class="candidateImag" src="' + proimage.url + '" alter=""/>'
            + '</div>'

            + '</div>';
    }



**/


  firebase.auth().onAuthStateChanged(function(user) {
    if (user) {
      auth = user;
      $('body').removeClass('auth-false').addClass('auth-true');
      usersRef.child(user.uid).once('value').then(function (data) {
        var info = data.val();
        if(user.photoUrl) {
          $('.user-info img').show();
          $('.user-info img').attr('src', user.photoUrl);
          $('.user-info .user-name').hide();
        } else if(user.displayName) {
          $('.user-info img').hide();
          $('.user-info').append('<span class="user-name">'+user.displayName+'</span>');
        } else if(info.firstName) {
          $('.user-info img').show();
          $('.user-info').append('<span class="user-name">'+info.firstName+'</span>');
        }
      });
      contactsRef.child(user.uid).on('child_added', onChildAdd);
    } else {
      // No user is signed in.
      $('body').removeClass('auth-true').addClass('auth-false');
      auth && contactsRef.child(auth.uid).off('child_added', onChildAdd);
      $('#contacts').html('');
      auth = null;
    }
  });
});

function onChildAdd (snap) {
  $('#contacts').append(contactHtmlFromObject(snap.key, snap.val()));
}



 
//prepare contact object's HTML
function contactHtmlFromObject(key, contact){
    return '<div class="card contact" style="width: 100%;" id="' + key + '">'
        + '<div class="card-header">' + '<span class="appliUnderProcess marginSpan" style="color:red !important;">'
        + contact.application
        + '</span>'
       

        + '<span class="badge aboutAppliNoConfirm" style="color:#808080 !important">' + 'अर्ज क्र. आपला अनुप्रयोग यशस्वीरित्या पूर्ण झाल्यास आपल्या ई-मेल आयडीवर पाठविला जाईल.'
        + '</span>'

        + '</div>'
        + '<div class="card-body">'
        + '<div class="candidateImagDiv">'
        + '<p class="">' + contact.imageStatus + '</p>'
        + '<img  class="candidateImag" src="' + contact.url + '"/>'
        + '</div>'
        + '<div class="input-group mb-3 noBorder">'
        + '<div class="input-group-prepend">'
        + '<span class="input-group-text marginSpan" id="addon-wrapping">' + 'नाव' + '</span>'
        + '</div>'
        + '<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="' + contact.name + '" disabled>'
        + '</div>'

        + '<div class="input-group mb-3 noBorder">'
        + '<div class="input-group-prepend">'
        + '<span class="input-group-text marginSpan" id="addon-wrapping">' + 'वय' + '</span>'
        + '</div>'
        + '<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="' + contact.age + '" disabled>'
        + '</div>'

        + '<div class="input-group mb-3 noBorder">'
        + '<div class="input-group-prepend">'
        + '<span class="input-group-text marginSpan" id="addon-wrapping ">' + 'फोन नं.' + '</span>'
        + '</div>'
        + '<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="' + contact.phone + '" disabled>'


        + '</div>'

        + '<div class="input-group mb-3 noBorder">'
        + '<div class="input-group-prepend">'
        + '<span class="input-group-text marginSpan" id="addon-wrapping ">' + 'ई-मेल' + '</span>'
        + '</div>'
        + '<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="' + contact.email + '" disabled>'


        + '</div>'


        + '<div class="input-group mb-3 noBorder">'
        + '<div class="input-group-prepend">'
        + '<span class="input-group-text marginSpan" id="addon-wrapping">' + 'पत्ता:' + '</span>'
        + '</div>'
        + '<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="' + contact.location.city + ', '
        + contact.location.state + ', '
        + contact.location.zip + '" disabled>'
        + '</div>'




       
        // + '<a href="#" class="card-link">Card link</a>'
        // + '<a href="#" class="card-link">Another link</a>'
        + '<div class="examPaymentTransact row">'
        + '<div class="form-group col" >'
        + '<label for="age">' + 'स्पर्धा / परिक्षे नाव'
       
        + '</label>'
        + '<a class="form-control btn btnGray ">' + contact.exam + '</a>'
        + '</div>'
        + '<div class="form-group col" >'
        + '<label for="age">' + 'परिक्षा पद्धती'

        + '</label>'
        + '<a class="form-control btn btnGray ">' + contact.method + '</a>'
        + '</div>'
       
        + '<div class="form-group col" >'
        + '<label for="age">' + 'परिक्षा शुल्क'

        + '</label>'
        + '<a class="form-control btn btnGray ">' + contact.fees + '</a>'
        + '</div>'
        + '<div class="form-group col" >'
        + '<label for="age">' + 'Do Your Contribution'

        + '</label>'

        + '<a class="form-control btn bg-success paymentProcess" href="' + contact.feeslink + '">' + contact.makepayment + '</a>'
        + '</div>'
        + ' </div>';

    
        + '</div>';
}

function spanText(textStr, textClasses) {
  var classNames = textClasses.map(c => 'text-'+c).join(' ');
  return '<span class="'+classNames+'">'+ textStr + '</span>';
}

