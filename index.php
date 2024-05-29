<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="Styles.css">
        <title>ahahah</title>

        <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

    </head>
    <body>
        <div class="menuBar">
            <option class=".menuButton" id="">Options</option>
            <button class=".menuButton" id="">Edit</button>
            <a class=".menuButton" href="./ImportNew.php">Import</a>
        </div>

        <div class="sideBar">
            <div class="sideBarContent">
                <div class="">
                </div>
                <div class="ParametersButtons">
                    <button class="buttonColour" id="">Kleur</button>
                    <button class="buttonMaterial" id="">Materiaal</button>
                </div>
            </div>

            <div class="MaterialColourContainer">
                <div class="Material"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
                <div class="Material"><img src="icwi"></div>
            </div> 
        </div>

        <div class="dropdown">
            <button onclick="toggleDropdown()" class="dropbtn">Selecteer Model</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#" onclick="changeModel('models/laars.gltf')">Model 1</a>
                <a href="#" onclick="changeModel('models/Laval.gltf')">Model 2</a>
                <a href="#" onclick="changeModel('models/rijlaars.glb')">Model 3</a>
            </div>
        </div>

        <div class="modelFrame">
            <model-viewer id="pickMaterial" src="models/laars.gltf" ar ar-modes="webxr" shadow-intensity="0" camera-controls touch-action="pan-y">
                <div class="controls" id ="material-controls">
                    <div id="fulltexture">
                        <button>None</button>
                        <button data-norm="models/wildleder-NORM.jpg" data-bumb="models/wildleder-bUMB.jpg" data-sw="models/wildleder-SW.jpg">wildleder</button> 
                        <button data-norm="models/Leather0021_Big.jpg" data-bumb="models/Leather0021_Big_001.jpg" data-sw="models/Leather0021_Big.png">Leather</button>
                        <button data-norm="norm.jpg" data-bumb="bumb.jpg" data-sw="sw.jpg">name</button>
                    </div>
                </div>  
            </model-viewer>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>GltfPath</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $model): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($model['Id']); ?></td>
                        <td><?php echo htmlspecialchars($model['Name']); ?></td>
                        <td><?php echo htmlspecialchars($model['GltfPath']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>





<script type="module">
    const modelViewer = document.querySelector("model-viewer#pickMaterial");

    var TextureBUMB = "models/wildleder-NORM.jpg";
    var TextureNORM = "models/wildleder-bUMB.jpg";
    var TextureSW = "models/wildleder-SW.jpg";
    
    modelViewer.addEventListener("load", () => {
    const ApplyTexture = (event) => {
    const material = modelViewer.materialFromPoint(event.clientX, event.clientY);
        if (material != null) {
        material.pbrMetallicRoughness.
        setBaseColorFactor([Math.random(), Math.random(), Math.random()]);
        }
    };

    const Collect = 
    
    modelViewer.addEventListener("click", ApplyTexture);

    // Takes values from the different buttons and attaches them to the different var's to later use for the texture aplications process.
    document.querySelector('#fulltexture').addEventListener('click', Collect);
    });
</script> 

<script>
    function toggleDropdown() {
   document.getElementById("myDropdown").classList.toggle("show");
    }

    // Functie om het model te veranderen
    function changeModel(modelSrc) {
    document.getElementById("pickMaterial").src = modelSrc;
    toggleDropdown(); // Verberg het dropdown-menu na het selecteren van een model
    }

    // Sluit het dropdown-menu als de gebruiker ergens buiten het menu klikt
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

<?php
require_once "Database.php";

$database = new Database();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"];
    $GltfPath = $_POST["GltfPath"];
    $result = $database->Create($Name, $GltfPath);
    echo $result;
}

$models = $database->GetModels();
?>