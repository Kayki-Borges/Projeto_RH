<script>
function handleCredentialResponse(response) {
  console.log("Encoded JWT ID token: " + response.credential);
}
window.onload = function () {
  google.accounts.id.initialize({
    client_id: "543793793556-rlo97asgftgul1624uo3phbbi4rh4eqr.apps.googleusercontent.com"
    callback: handleCredentialResponse
  });
  google.accounts.id.renderButton(
    document.getElementById("buttonDiv"),
    { theme: "outline", size: "large" }  // customization attributes
  );
  google.accounts.id.prompt(); // also display the One Tap dialog
}
</script>