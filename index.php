<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>model viewer test</title>
        <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
        <link rel="stylesheet" href="Styles.css">
    </head>
    <body>
        <div class="menuBar">
            
        </div>
        <div class="sideBar">
            <!-- de controls zorgen ervoor dat je kleuren en textures kunt aanpassen -->
            <div class="controls" id ="Texture-controls">
                <p>Normals</p>
                <select id="normals">
                    <option value="models/wildleder-NORM.jpg">Wildleder</option>
                    <option value="models/Fabric061_1K-JPG_NormalGL.jpg">Canvas</option>
                    <option value="models/Metal029_1K-JPG_NormalGL.jpg">Rubber</option>
                </select>
                <p>pbrMetallicRoughness</p>
                <select id="pbrMetallicRoughness">
                    <option value="models/wildleder-bUMB.jpg">Wildleder</option>
                    <option value="models/Fabric061_1K-JPG_Roughness.jpg">Canvas</option>
                    <option value="models/Metal029_1K-JPG_Roughness.jpg">Rubber</option>
                </select>
                <p>Emission</p>
                <select id="emission">
                    <option value="models/wildleder-SW.jpg">Wildleder</option>
                    <option value="models/Fabric061_1K-JPG_Displacement.jpg">Canvas</option>
                    <option value="models/Metal029_1K-JPG_Displacement.jpg">Rubber</option>
                </select>
                <P>Color</P>
                <select id="Color">
                    <option value="#ff0000">Red</option>
                    <option value="#00ff00">Green</option>
                    <option value="#0000ff">Blue</option>
                    <option value="#ffffff">white</option>
                    <option value="#000000">Black</option>
                    <option value="#AFD8BD">Mint</option>
                    <option value="#FF5733 ">Dark Brown</option>
                    <option value="#C8A2C8">Lilac</option>
                    <option value="#4B0082">Indigo</option>
                    <option value="#C9A0DC">Wisteria</option>
                    
                </select>
            </div>
            
            <!-- deze dropdown zorgt ervoor dat je verschillende modellen kunt uitkiezen -->
            <div class="dropdown">
            <button onclick="toggleDropdown()" class="dropbtn">Selecteer Model</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#" onclick="changeModel('models/laars.gltf')">Model 1</a>
                <a href="#" onclick="changeModel('models/Aurelio_Jayson.glb')">Model 2</a>
                <a href="#" onclick="changeModel('models/rijlaars.glb')">Model 3</a>
            </div>
            </div>

            <!-- met deze knop kun je dingen aan het tabel 3dModels toevoegen -->
            <form method="POST" action="index.php">
                <label for="name">Name:</label>
                <input type="text" id="Name" name="Name" required><br>
                <label for="GltfPath">Path:</label>
                <input type="GltfPath" id="GltfPath" name="GltfPath" required><br>
                <button type="submit">Add Model</button>
            </form>
        </div>
            <div class="modelFrame">
            <!-- dit zorgt ervoor dat het model kan worden ingeladen in de webbrouser -->
            <model-viewer id="Models" src="models/laars.gltf" ar ar-modes="webxr" shadow-intensity="0" camera-controls touch-action="pan-y" disable-tap disable-pan></model-viewer>
        </div>

        





    </body>
</html>



<script type="module">
            //deze functie zorgt voor het aanpassen en toepassen van kleuren en textures
            const modelViewer = document.querySelector("model-viewer#Models");
            
            modelViewer.addEventListener("load", () => {
                const ApplyTexture = async (event) => {

                    let appliedTextures = {};

                    const material = modelViewer.materialFromPoint(event.clientX, event.clientY);

                    appliedTextures.normals = await modelViewer.createTexture(document.querySelector("#normals").value);
                    appliedTextures.pbrMetallicRoughness = await modelViewer.createTexture(document.querySelector("#pbrMetallicRoughness").value);
                    appliedTextures.emission = await modelViewer.createTexture(document.querySelector("#emission").value);

                    const colorString = await document.querySelector('#Color').value;

                    if (material != null) {
                        if (appliedTextures.normals) material.normalTexture.setTexture(appliedTextures.normals);

                        if (appliedTextures.pbrMetallicRoughness) material.pbrMetallicRoughness.metallicRoughnessTexture.setTexture(appliedTextures.pbrMetallicRoughness);

                        if (appliedTextures.emission) material.emissiveTexture.setTexture(appliedTextures.emission);

                        if (colorString) material.pbrMetallicRoughness.setBaseColorFactor(colorString);;
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

//deze code zorgt ervoor dat je op een specifieke plek in een tabel iets kan toevoegen met een POST method
$database = new Database();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"];
    $GltfPath = $_POST["GltfPath"];
    $result = $database->Create($Name, $GltfPath);
    echo $result;
}
?>