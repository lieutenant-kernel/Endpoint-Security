<?php

$dir = __DIR__;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($_FILES['files']['name'] as $i => $name) {

        $tmp = $_FILES['files']['tmp_name'][$i];
        $target = $dir . "/" . basename($name);

        if(move_uploaded_file($tmp,$target)){
            echo "Uploaded: $name\n";
        } else {
            echo "Failed: $name\n";
        }
    }

    exit;
}

$files = array_diff(scandir($dir), ['.','..']);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Simple Upload</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
margin:40px;
}

#drop{
border:3px dashed #888;
padding:50px;
text-align:center;
font-size:20px;
background:white;
}

#drop.drag{
border-color:#2ecc71;
}

progress{
width:100%;
height:25px;
margin-top:20px;
}

ul{
background:white;
padding:20px;
}

</style>

</head>
<body>

<h2>File Upload</h2>

<div id="drop">
Drag & Drop files here<br><br>
<input type="file" id="fileinput" multiple>
</div>

<progress id="progress" value="0" max="100" style="display:none"></progress>

<h3>Files</h3>

<ul>
<?php foreach($files as $f): ?>
<li><a href="<?=htmlspecialchars($f)?>"><?=htmlspecialchars($f)?></a></li>
<?php endforeach ?>
</ul>

<script>

let drop = document.getElementById("drop")
let input = document.getElementById("fileinput")
let progress = document.getElementById("progress")

function upload(files){

let form = new FormData()

for(let f of files){
form.append("files[]",f)
}

let xhr = new XMLHttpRequest()

xhr.open("POST","upload.php")

progress.style.display="block"

xhr.upload.onprogress = e=>{
if(e.lengthComputable){
progress.value = (e.loaded/e.total)*100
}
}

xhr.onload = ()=>{
location.reload()
}

xhr.send(form)

}

drop.ondragover = e=>{
e.preventDefault()
drop.classList.add("drag")
}

drop.ondragleave = e=>{
drop.classList.remove("drag")
}

drop.ondrop = e=>{
e.preventDefault()
drop.classList.remove("drag")
upload(e.dataTransfer.files)
}

input.onchange = ()=>{
upload(input.files)
}

</script>

</body>
</html>