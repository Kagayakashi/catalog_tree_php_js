// Ajax в папку /public/api/*

function ajax(url, data) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  xhttp.open('POST', '/api/' + url + '/index.php', true);
  xhttp.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
  xhttp.send(data);
}
