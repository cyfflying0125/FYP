<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
  	<title>Wedding Planner</title>

	</head>
	<body>
    <div id="wrapper">
    <div class="leftpanel">
      <table class="userProfileTable">
        <tr>
          <td><img src="icon/profile.png" alt="profile.png" width="88" height="88" style="background:white; border-radius: 44px;"></td>
          <th>ALBUS TAN &hearts; <br> ALICE WONG</th>
        </tr>
      </table>
      <div class = "leftnav">
        <table>
          <tr><th>56</th></tr>
          <tr><td> Days to the BIG DAY <br>
          - <b>11 MAR 2022</b></td></tr>
        </table>
        <ul>
         <li><a href="index.php">Venue</a></li>
         <li><a href="calendar.html">Calendar</a></li>
         <li><a href="budget.html">Budget</a></li>
         <li><a href="community.html">Community</a></li>
         <li><a href="account.html">Account Settings</a></li>
        </ul>
      </div>
    </div>
    <div id = "canvas">
      <select name="venue" id="venue">
        <option value="0" hidden>Select a Layout...</option>
        <option value="1" selected>Layout 1</option>
      </select>
      This is the status bar.
      <div id = "infobar" style="display: none;">
				<form action="">
					<input type="hidden" id="identifier" name="identifier" value=""></input>
				</form>


      </div>

			<script type="module">
			import * as THREE from '/f32ee/WeddingPlanner/three/build/three.module.js';
			import { GLTFLoader } from '/f32ee/WeddingPlanner/three/examples/jsm/loaders/GLTFLoader.js';
			import { OBJLoader } from '/f32ee/WeddingPlanner/three/examples/jsm/loaders/OBJLoader.js';
			import { OrbitControls } from '/f32ee/WeddingPlanner/three/examples/jsm/controls/OrbitControls.js';

			//Add new scene
			const scene = new THREE.Scene();
			scene.background = new THREE.Color(0xffedec);

			//Camera
			const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000 );

			//Renderer
			const renderer = new THREE.WebGLRenderer({antialias: true});
			renderer.setSize(window.innerWidth, window.innerHeight);
			renderer.setSize(1080,580);
			const canvas = document.getElementById('canvas');
			canvas.appendChild(renderer.domElement);

			//Controls
			const controls = new OrbitControls( camera, renderer.domElement);
			controls.maxPolarAngle = Math.PI/2;
			camera.position.set(5, 12, 24);
			controls.update();

			//Resize
			window.addEventListener('resize', function() {
				var width = window.innerWidth;
				var height = window.innerHeight;
				renderer.setSize( width, height);
				camera.aspect = width/height;
				camera.updateProjectionMatrix();
			})

			//grid
			const gridHelper = new THREE.GridHelper( 1000, 20 );
				scene.add( gridHelper );

			//Light
			const light = new THREE.AmbientLight( 0xffffff, 0.6); // soft white light
			scene.add( light );
			const pointLight = new THREE.PointLight( 0xffffff, 0.6 );
			pointLight.position.set( 25, 50, 25 );
			scene.add( pointLight );

			//raycaster
			const raycaster = new THREE.Raycaster(); // create once
			const clickMouse = new THREE.Vector2();  // create once
			const moveMouse = new THREE.Vector2();   // create once
			var draggable = new THREE.Object3D();

			function intersect(pos) {
				raycaster.setFromCamera(pos, camera);
				return raycaster.intersectObjects(scene.children);
			}
			window.addEventListener('click', event => {
				if (draggable != null && typeof draggable.userData.name !== 'undefined') {
					console.log(`dropping draggable ${draggable.userData.name}`);
					draggable = null;

					return;
				}

				// THREE RAYCASTER
				clickMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
				clickMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

				const found = intersect(clickMouse);
				if (found.length > 0) {
					if (found[0].object.userData.draggable) {
						draggable = found[0].object;
						console.log(`found draggable ${draggable.userData.name}`);
					//	document.getElementById("identifier").value = draggable.userData.name;
						document.getElementById("infobar").style.display = "";
						findAssetInfo(draggable.userData.name);
						//found[0].object.material.color.set(0xff0000);
					}
				}
			});

			function findAssetInfo(str) {
				console.log("FAI called");
				const xhttp = new XMLHttpRequest();
				xhttp.onload = function() {
					document.getElementById("infobar").innerHTML = this.responseText;
				}
				xhttp.open("GET", "infobar.php?name="+str);
				xhttp.send();
				}


			window.addEventListener('mousemove', event => {
			moveMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
			moveMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
			});
			//plane
			function createFloor() {
				let pos = { x: 0, y: -1, z: 0 };
				let scale = { x: 100, y: 2, z: 100 };

				let blockPlane = new THREE.Mesh(new THREE.BoxBufferGeometry(),
						 new THREE.MeshPhongMaterial({ color: 0xf9c834 }));
				blockPlane.position.set(pos.x, pos.y, pos.z);
				blockPlane.scale.set(scale.x, scale.y, scale.z);
				blockPlane.castShadow = true;
				blockPlane.receiveShadow = true;

				blockPlane.userData.draggable = false;
				blockPlane.userData.ground = true;
				scene.add(blockPlane);

			}

			function createAsset(modelPath,x,y,z) {
				const objLoader = new OBJLoader();

				objLoader.loadAsync('./assets/' + modelPath).then((group) => {
					const asset = group.children[0];

					asset.position.x = x;
					asset.position.y = y;
					asset.position.z = z;

					asset.scale.x = 1;
					asset.scale.y = 1;
					asset.scale.z = 1;

					asset.rotation.x = -Math.PI/2;

					asset.castShadow = true;
					asset.receiveShadow = true;

					asset.userData.draggable = true;
					asset.userData.name = '' + modelPath;

					//console.log(`created asset ${asset.userData.name}`);

					scene.add(asset);
				})
			}

			function dragObject() {
				if (draggable != null) {
					const found = intersect(moveMouse);
					if (found.length > 0) {
						for (let i = 0; i < found.length; i++) {
							if (!found[i].object.userData.ground)
								continue;

							let target = found[i].point;
							draggable.position.x = target.x;
							draggable.position.z = target.z;
						}
					}
				}
			}

			<?php
				$query = "SELECT * FROM scene";
				$result = $db->query($query);
				$num_results = $result->num_rows;
				for($i=0; $i<$num_results; $i++) {
					$row = $result->fetch_assoc();
					$filePath = $row['filePath'];
					$px = $row['Px'];
					$py = $row['Py'];
					$pz = $row['Pz'];
			?>
				//console.log('<?php echo $filePath;?>');
				createAsset('<?php echo $filePath;?>',
											<?php echo $px, "," , $py , "," , $pz;?>);
			<?php
				}
			?>
			createFloor();
			//Animate
			const animate = function() {
				dragObject();
				requestAnimationFrame( animate );
				renderer.render(scene,camera);
			};
			animate();

			</script>

    </div>

    </div>


</body>
</html>
