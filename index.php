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

            <div class="controls" id ="material-controls">
                <p>Normals</p>
                <select id="normals">
                    <option value="models/wildleder-NORM.jpg">wildleder</option>
                </select>
                <div>
                    <p>Occlusion</p>
                    <select id="occlusion">
                        <option value="models/wildleder-bUMB.jpg">wildleder</option>
                    </select>
                </div>
                <div>
                    <p>Emission</p>
                    <select id="emission">
                        <option value="models/wildleder-SW.jpg">wildleder</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <button onclick="toggleDropdown()" class="dropbtn">Selecteer Model</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#" onclick="changeModel('models/laars.gltf')">Model 1</a>
                <a href="#" onclick="changeModel('models/Aurelio_Jayson.glb')">Model 2</a>
                <a href="#" onclick="changeModel('models/rijlaars.glb')">Model 3</a>
            </div>
        </div>

        <div class="modelFrame">
            <model-viewer id="Models" src="models/laars.gltf" ar ar-modes="webxr" shadow-intensity="0" camera-controls touch-action="pan-y" disable-tap disable-pan>
                  
            </model-viewer>
        </div>

        <form method="POST" action="index.php">
    <label for="name">Name:</label>
    <input type="text" id="Name" name="Name" required><br>
    <label for="GltfPath">Path:</label>
    <input type="GltfPath" id="GltfPath" name="GltfPath" required><br>
    <button type="submit">Add Model</button>
</form>

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
    const modelViewer = document.querySelector("model-viewer#Models");

    modelViewer.addEventListener("load", () => {
    const ApplyTexture = async (event) => {

        let appliedTextures = {};

        const material = modelViewer.materialFromPoint(event.clientX, event.clientY);

        appliedTextures.normals = await modelViewer.createTexture(document.querySelector("#normals").value);

        appliedTextures.occlusion = await modelViewer.createTexture(document.querySelector("#occlusion").value);

        appliedTextures.emission = await modelViewer.createTexture(document.querySelector("#emission").value);

        if (material != null) {

        if (appliedTextures.normals) material.normalTexture.setTexture(appliedTextures.normals);

        if (appliedTextures.occlusion) material.occlusionTexture.setTexture(appliedTextures.occlusion);

        if (appliedTextures.emission) material.emissiveTexture.setTexture(appliedTextures.emission);
            }
    };

    modelViewer.addEventListener("click", ApplyTexture);

    });
</script> 

<script>
    function toggleDropdown() {
   document.getElementById("myDropdown").classList.toggle("show");
    }

    // Functie om het model te veranderen
    function changeModel(modelSrc) {
    document.getElementById("Models").src = modelSrc;
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