
        const modelViewerTexture = document.querySelector("model-viewer#shoe");
        const textureName = document.querySelector('#texture-name');
        const imageName = document.querySelector('#image-name');

        modelViewerTexture.addEventListener("load", () => {

        const material = modelViewerTexture.model.materials[0];

        const createAndApplyTexture = async (channel, event) => {
            if (event.target.value == "None") {
        
            material[channel].setTexture(null);

            textureName.innerText = "None";
            imageName.innerText = "None";
            } else if (event.target.value) {

            const texture = await modelViewerTexture.createTexture(event.target.value);

            texture.name = event.target.options[event.target.selectedIndex].text.replace(/ /g, "_").toLowerCase();

            material[channel].setTexture(texture);
            textureName.innerText = texture.name;
            imageName.innerText = texture.source.name;
            }
        }

        document.querySelector('#normals2').addEventListener('input', (event) => {
            createAndApplyTexture('normalTexture', event);
        });
        });

        const modelViewerColor = document.querySelector("model-viewer#shoe");

        document.querySelector('#color-controls').addEventListener('click', (event) => {
        const colorString = event.target.dataset.color;
        const [material] = modelViewerColor.model.materials;
        material.pbrMetallicRoughness.setBaseColorFactor(colorString);
        });

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>


