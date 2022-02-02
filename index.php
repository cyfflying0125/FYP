<?php include 'connect.php';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
  	<title>Wedding Planner</title>
		<script type="text/javascript" src="js/buttonManager.js"></script>
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
      <div id = "infobar" style="display: none;">  </div>
			<div id = "sidemenu">
				<table>
						<input type="hidden" id="actionBtn" value="">
						<tr><td><button id="add" onclick="openDropdownAdd();">Add</button></td></tr>
						<tr><td><button id="delete" disabled>Delete</button>
										<input type="hidden" id="currentObj" value=""></td></tr>
						<tr><td><button id="swap" onclick="openDropdownSwap();">Swap</button></td></tr>
				</table>
			</div>
			<?php
				$query = "SELECT assetType, filePath, description, rotation, scale FROM assets";
				$result = $db->query($query);
				$num_results = $result->num_rows;

			?>
			<div id="dropdownAdd">
				<input type="hidden" id="path" value="">
				<input type="hidden" id="rotation" value="">
				<input type="hidden" id="scale" value="">
			  <button class="dropdown-btn" onclick="dropdown('table');">Tables <span style="font-size: 10px;">&#9660;</span></button>
			  <div class="dropdown-container" id="tableDropdown">
					<?php
						for($i=0; $i<$num_results; $i++) {
							$row = $result->fetch_assoc();
							if($row['assetType'] == 'table') {
								?>
								<a href="#" class ='selectObj' onclick="addObj('<?php echo $row['filePath']; ?>',
									<?php echo $row['rotation'],',',$row['scale'];?>);">	<?php echo $row['description']; ?></a>
								<?php

							}
						}
					?>

			  </div>
				<button class="dropdown-btn" onclick="dropdown('chair');">Chairs <span style="font-size: 10px;">&#9660;</span></button>
			  <div class="dropdown-container" id="chairDropdown">
			    <a href="#">Chair 1</a>
			    <a href="#">Chair 2</a>
			  </div>
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
			controls.minDistance = 60;
			controls.maxDistance = 800;
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


			 //On Select
				const found = intersect(clickMouse);
				if (found.length > 0) {
					if (found[0].object.userData.draggable) {
						draggable = found[0].object;
						console.log(`found draggable ${draggable.userData.name}`);
						document.getElementById("infobar").style.display = "";
						document.getElementById("delete").disabled = false;
						document.getElementById("currentObj").value = draggable.name;
						//draggable.material.color.set(0xDBF3FA);
						findAssetInfo(draggable.userData.name);

					}
				}
			});

			function findAssetInfo(str) {
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

			document.getElementById( 'delete' ).addEventListener( 'click', function () {
				var obj = document.getElementById("currentObj").value + '';
				if(confirm("Are you sure you want to delete this item?")){
					removeObject(obj);
					console.log('delete is clicked on ' + obj);
				}
			} );

			var container = document.getElementById('dropdownAdd');
			var selections = container.getElementsByClassName('selectObj');
			for (var i = 0; i < selections.length; i++) {
				selections[i].addEventListener( 'click', function () {
					var path = document.getElementById("path").value + '';
					var r = document.getElementById("rotation").value;
					var s = document.getElementById("scale").value;

					if (document.getElementById('actionBtn').value == 'add') {
						createAsset(null,path,20,0,20,r,s);
						console.log('actionbtn = add');
					} else if (document.getElementById('actionBtn').value == 'swap') {
						console.log('actionbtn = swap');
						var obj = document.getElementById("currentObj").value + '';
						removeObject(obj);
						
					}

				} );

			}



			var oldColor = 0;
			var HOVERED = null;

			function dragObject() {
				if (draggable != null) {
					const found = intersect(moveMouse);
					if (found.length > 0) {
						if (HOVERED != found[0].object && !found[0].object.userData.ground) {
							if (HOVERED != null) {
								HOVERED.material.color.setHex(oldColor);
								HOVERED = null;
							}
							HOVERED = found[0].object;
							oldColor = found[0].object.material.color.getHex();
							found[0].object.material.color.set(0xDBF3FA);
					//		console.log('hovered');
						}

						for (let i = 0; i < found.length; i++) {
							if (!found[i].object.userData.ground) continue;

							let target = found[i].point;
							draggable.position.x = target.x;
							draggable.position.z = target.z;
						}
					}
				}
			}
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

			function createAsset(id,modelPath,x,y,z,r,s) {
				const objLoader = new OBJLoader();

				objLoader.loadAsync('./assets/' + modelPath).then((group) => {
					const asset = group.children[0];

					asset.position.x = x;
					asset.position.y = y;
					asset.position.z = z;

					asset.scale.x = s;
					asset.scale.y = s;
					asset.scale.z = s;

					asset.rotation.x = Math.PI * r;

					asset.castShadow = true;
					asset.receiveShadow = true;

					asset.userData.draggable = true;
					asset.userData.name = '' + modelPath;
					asset.name = '' + id;

					console.log(`created asset ${asset.name}`);

					scene.add(asset);
				})
			}
			function removeObject(name) {
				var obj = scene.getObjectByName(name);
				scene.remove(obj);
			}
			<?php
				$query = "SELECT * FROM scene";
				$result = $db->query($query);
				$num_results = $result->num_rows;
				for($i=0; $i<$num_results; $i++) {
					$row = $result->fetch_assoc();
					$sceneid = $row['sceneID'];
					$filePath = $row['filePath'];
					$px = $row['Px'];
					$py = $row['Py'];
					$pz = $row['Pz'];
					$rotation = $row['rotation'];
					$scale = $row['scale'];

			?>
				//console.log('<?php echo $filePath;?>');

				createAsset('<?php echo $sceneid;?>',
											'<?php echo $filePath;?>',
											<?php echo $px, "," , $py , "," , $pz, "," , $rotation, "," ,$scale;?>);
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
