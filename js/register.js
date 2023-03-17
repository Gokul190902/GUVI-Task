$(document).ready(function () {
  if (localStorage.getItem("redisId")) {
    window.location.replace("http://localhost/Guvi-Task/profile.html");
  }
});
$("#register-form").submit(function (event) {
  event.preventDefault();
  const formData = {
    email: $("#email").val(),
    password: $("#password").val(),
    confirmPassword: $("#confirm-password").val(),
    mobile: $("#mobile").val(),
    age: $("#age").val(),
    dob: $("#dob").val(),
    name: $("#name").val(),
  };
  $.ajax({
    type: "POST",
    url: "http://localhost/Guvi-Task/php/register.php",
    data: formData,

    success: function (response) {
      window.location.href = "http://localhost/Guvi-Task/login.html";
      // console.log(response);
      // let res = JSON.parse(response);
      // if (res.message == "Success") {
      //   window.location.href = "http://localhost/Project/login.html";
      // } else {
      //   setErrorMessage(res.message);
      // }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(errorThrown); // log error message to console
    },
  });
  console.log(formData);
});
