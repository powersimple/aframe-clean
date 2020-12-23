<!DOCTYPE html>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-64Y5HTMWJ5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-64Y5HTMWJ5');
    </script>


    <meta charset="utf-8">
    <title>The Polys - 2020 WebXR Awards | Presented by Powersimple </title>
    <meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="description" content="VR Anthropology Viewer">
    <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@v6.1.0/dist/aframe-extras.min.js"></script>
    <script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
    <script src="js/aframe-physics-system.js"></script>
    <script src="js/aframe-look-controls.js"></script>

    <script src="js/aframe-svgfile-component.min.js"></script>
    <script src="https://unpkg.com/aframe-svg-extruder@1.0.0/dist/index.min.js"></script>
    <script src="https://unpkg.com/aframe-aabb-collider-component@3.1.0/dist/aframe-aabb-collider-component.min.js">
    </script>
    <script src="https://unpkg.com/super-hands@3.0.0/dist/super-hands.min.js"></script>
    <script src="https://unpkg.com/aframe-physics-extras@0.1.2/dist/aframe-physics-extras.min.js"></script>
    <script src="js/aframe-teleport-controls.js"></script>
    <script src="js/aframe-troika-text.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>

</head>

<body>
    <a-scene gltf-model="dracoDecoderPath: draco/;" grab-panels burial-grab item-grab device-set
        device-orientation-permission-ui physics="iterations: 30;"
        inspector="https://cdn.jsdelivr.net/gh/aframevr/aframe-inspector@master/dist/aframe-inspector.min.js"
        loading-screen="backgroundColor: #12171a" renderer="colorManagement: true; foveationLevel: 2;"
        background="color: #FAFAFA">


        <a-assets timeout="80000">
            <!-- Loads models -->
            <a-asset-item id="pedestal" response-type="arraybuffer" src="models//pedestal.glb"></a-asset-item>
            <a-asset-item id="room" id="room" response-type="arraybuffer" position="0 0 -5" src="models//Ring.glb">
            </a-asset-item>
            <a-asset-item id="buttonmodel" response-type="arraybuffer" src="models//button.glb"></a-asset-item>
            <a-asset-item id="buttonupmodel" response-type="arraybuffer" src="models//button-up.glb"></a-asset-item>
            <img id="sky" src="images/skybox/redmilkway.jpg">

            <a-asset-item id="vuzix-blade" response-type="arraybuffer" src="images/glb/Vuzix-Blade.glb"></a-asset-item>
            <a-asset-item id="#poly" response-type="arraybuffer" src="models/Poly.glb"></a-asset-item>



            <a-mixin id="obj" hoverable
                grabbable="startButtons: trackpaddown, triggerdown, gripclose, gripdown, abuttondown, bbuttondown, xbuttondown, ybuttondown, thumbstickdown, mousedown; endButtons: trackpadup, triggerup, gripopen, gripup, abuttonup, bbuttonup, xbuttonup, ybuttonup, thumbstickup, mouseup"
                class="grabbable" scale="1 1 1" rotation="0 0 0"
                animation="property: object3D.position.y; to: 1.45; startEvents: standtrigger; dur: 5000" shadow>
            </a-mixin>
            <a-mixin id="button" static-body hoverable
                clickable="startButtons: trackpaddown, triggerdown, gripclose, gripdown, thumbstickdown, mousedown; endButtons: trackpadup, triggerup, gripopen, gripup, thumbstickup, mouseup"
                scale="1 1 1" shadow></a-mixin>


            <a-mixin id="holoprojector" lass="center-zone" color="#ff6a00" position="0 0.3 0" rotation="180 0 0"
                height="0.05"
                geometry="primitive: cone; segmentsRadial: 3; openEnded: true; radiusBottom: 0.5; segmentsHeight: 1"
                material="emissive: #ff6a00; wireframe: true"
                animation="property: rotation; to: 180 360 0; loop: true; easing: linear; dur: 10000"></a-mixin>


            <a-mixin id="hand" physics-collider static-body="shape: box" collision-filter="collisionForces: false;"
                super-hands="colliderEvent: collisions;
                              colliderEventProperty: els;
                              colliderEndEvent: collisions;
                              colliderEndEventProperty: clearedEls;
                              grabStartButtons: trackpaddown, triggerdown, gripclose, gripdown, thumbstickdown, mousedown; 
                              grabEndButtons: trackpadup, triggerup, gripopen, gripup, thumbstickup, mouseup"
                teleport-controls="cameraRig: #rig; teleportOrigin: #camera;  startEvents: teleportstart; endEvents: teleportend; hitCylinderColor: #e9974c; interval: 10; curveHitColor: #e9974c; curveNumberPoints: 48; curveShootingSpeed: 12"
                buttons></a-mixin>
            <a-mixin id="table-label" position="0 0 -1" rotation="0 0 0" visible="false"
                text="width: 2; color: black; lineHeight: 60; wrap-count: 35"></a-mixin>
            <a-mixin id="burial-label" position="0 0 -1" text="width: 2; color: black; lineHeight: 60; wrap-count: 35">
            </a-mixin>
            <a-mixin id="table-caption" text="align: right; color: black; lineHeight: 55; wrap-count: 50"></a-mixin>
            <a-mixin id="scale-box" visible="false"></a-mixin>
            <a-mixin id="scale-label-border" geometry="primitive: plane; height: 1.05; width: 1.05; buffer: false"
                material="color: #375719; shader: flat;"></a-mixin>
            <a-mixin id="scale-label" geometry="primitive: plane; height: 1; width: 1; buffer: false"
                material="color: #f5f5f5; shader: flat;"></a-mixin>
            <a-mixin id="scale-text" text="color: black; width: 2; wrapCount: 45"></a-mixin>
            <a-mixin id="credit-text" text="anchor: align; color: black; width: 2; wrapCount: 70; lineHeight: 55">
            </a-mixin>
        </a-assets>
        <a-sky src="#sky"></a-sky>
        <!--  
        <a-entity position="0 -1 -5" rotation="0 0 -0.45" gltf-model="models//Ring.glb" id="nav" nav-mesh
            visible="false"></a-entity>  collisionEntities: #nav;  Nav Mesh -->
        <a-entity position="0 -1 -5" rotation="0 0 -0.45" gltf-model="models//Ring.glb"></a-entity> <!-- Building -->

        <a-entity id="rig" rotation-reader movement-controls="speed: 0.1; constrainToNavMesh: true" position="0 0.01 1">
            <!-- Player Character -->
            <a-box id="body" plane-hit aabb-collider="collideNonVisible: true; objects: .zone" static-body="shape: box"
                position="0 0.05 0" width="0.25" height="0.25" depth="0.25" visible="false"></a-box>
            <a-entity id="camera" camera look-controls capture-mouse wasd-controls="acceleration:100; fly:true"
                cursor="rayOrigin:mouse" camera="zoom: 1"
                raycaster="far: 5; objects: .clickable" super-hands="colliderEvent: raycaster-intersection;
                             colliderEventProperty: els;
                             colliderEndEvent:raycaster-intersection-cleared;
                             colliderEndEventProperty: clearedEls;" position="0 1.6 0"></a-entity>
            <a-entity mixin="hand" hand-controls="hand: left; handModelStyle: lowPoly; color: #ffcccc"></a-entity>
            <a-entity mixin="hand" hand-controls="hand: right; handModelStyle: lowPoly; color: #ffcccc"></a-entity>
        </a-entity>

        <a-light type="ambient" color="white" intensity="0.025"></a-light>
        <a-light type="directional" color="white" intensity="1" position="-1 8 4"></a-light> <!-- Spawn light cbf1ff -->


        <!-- Wall Text -->
        <!-- Front wall -->
        <a-entity id="info-wall" visible="true" static-body position="0 12 -16" rotation="0 0 0" width="40"
            height="4.5">



            <!-- VR Grab Lab Title -->
            <a-text position="0 0 0" value="2020 WebXR Awards" color="white" width="40" text="align:center"></a-text>
            <a-text position="0 -1.5 0" value="Honoring Achievements in Immersive Web Development" color="white"
                width="16.5" text="wrapCount:50;align:center"></a-text>
            <a-text position="0 -3 0" value="1.2.21" color="white" width="10" text="wrapCount:10;align:center"></a-text>

            <a-text id="GL-VR" visible="false" position="2.55 -0.1 0.01" value="" color="white" width="4"
                line-height="50" text="wrapCount: 30"></a-text>
            <a-text id="GL-PC" visible="false" position="2.55 -0.1 0.1" value="Info: Click on objects" color="black"
                width="5" line-height="50" text="wrapCount: 30"></a-text>
            <a-text id="GL-SP" visible="false" position="2.55 -0.1 0.1" value="Info: Touch objects" color="black"
                width="5" line-height="50" text="wrapCount: 30"></a-text>


            <a-text id="SMH-VR" visible="false" position="-6.65 -0.57 0.01" value="" color="black" width="5"
                line-height="60" text="wrapCount: 30"></a-text>
            <a-text id="SMH-PC" visible="false" position="-6.65 -0.75 0.01"
                value="Move: WASD keys\n\nLook: Drag mouse\n\nInfo: Click orbs\n\n" color="black" width="5"
                line-height="40" text="wrapCount: 30"></a-text>
            <a-text id="SMH-SP" visible="false" position="-6.65 -0.6 0.01"
                value="Move: Touch screen. Double-touch to reverse.\n\nInfo: Touch orb" color="black" width="5"
                line-height="50" text="wrapCount: 25"></a-text>

        </a-entity>












        <!-- Artifact table -->
        <a-entity class="center-zone" id="table-poly" position=" 0 .2 0" rotation="0 90 0">
            <a-light type="point" color="white" position="0 5 0"></a-light>
            <!-- This sets the relative state of the table -->
            <a-entity class="table" static-body="shape: box;" scale="1 1 1" id="poly-pedestal" gltf-model="#pedestal"
                shadow="cast: false; receive: false"></a-entity>
            <a-entity rotation="0 270 0" position="-0.201 0.89 0">
                <a-plane height="0.2" width="0.5" color="#7a7a7a"
                    text="value:The Poly Award; color:#f5f5f5; align:center; wrapCount:15;" side="double"></a-plane>
            </a-entity>

            <a-entity id="poly-grab" class="clickable center-obj-zone" dynamic-body="shape: box; mass: 2"
                position="0 1.01 0" mixin="obj" rotation="0 180 0" scale="0.5 0.5 0.5" gltf-model="models/poly.glb">
            </a-entity>

            <a-entity id="poly-card" rotation="0 0 0" position="3.873 1.5 -0.047">
                <a-text id="poly-title" class="art-text" mixin="table-label" position="0 0 -3" color="white" width="2.5"
                    rotation="0 -90 0"
                    text="value: Meet Poly. She honors humanity's first connections to Spatial Content. Based on the 25,000 year old paleolithic limestone carving known as 'The Venus of Willendorf', Poly wears a VR Headset with a WebXR Emblem for a Crown. She has no feet so she levitates over her pedestal. Poly may be gone, but here she lives forever as a symbol of the 3D Medium.;wrap-count:30 ">
                    <a-entity position="3.75 0 0" rotation="0 0 0">
                        <a-image mixin="scale-label" src="images/logo/FrameVR-01.png" position="1 0 0"
                            width="2" height="2">
                        </a-image>

                        <a-entity
                            link="href: https://www.vuzix.com/Products/AddToCart/157; title: Order Now from Vuzix.com;"
                            position="1.25 -1.56 0.01"></a-entity>

                    </a-entity><!-- Photo Caption -->
                    <!-- Image Panels -->
                </a-text>
            </a-entity>
        </a-entity>

        <!-- Artifact table -->
        <a-entity class="center-zone" id="table-ltaa" position=" 0.83 .2 0.02" rotation="0 90 0">
            <!-- This sets the relative state of the table -->
            <a-entity class="table" static-body="shape: box;" scale="1 1 1" id="ltaa-pedestal" gltf-model="#pedestal"
                shadow="cast: false; receive: false"></a-entity>
            <a-entity rotation="0 270 0" position="-0.201 0.89 0">
                <a-plane height="0.2" width="0.5" color="#7a7a7a"
                    text="value:Lifetime Achievement; color:#f5f5f5; align:center; wrapCount:15;" side="double">
                </a-plane>
            </a-entity>

            <a-entity id="ltaa-grab" class="clickable center-obj-zone" dynamic-body="shape: box; mass: 2"
                position="0 1.01 0" mixin="obj" rotation="0 180 0" scale="0.5 0.5 0.5" gltf-model="models/poly.glb">
            </a-entity>

            <a-entity id="ltaa-card" rotation="0 0 0" position="3.873 1.5 -0.047">
                <a-text id="ltaa-title" class="art-text" mixin="table-label" position="0 0 -3" color="white" width="2.5"
                    rotation="0 -90 0"
                    text="value: Ricardo Cabello is the creator of ThreeJS known by the handle Mr. Doob. Since 2010 he has maintained one of the most influential open source repos in history, which is foundational to WebXR.  ThreeJS has over 120 releases, over 35,000 commits and has been forked over 25,000 times. It abstracts WebGL to JavaScript democratizing 3D graphics for Web Programmers. The WebXR Awards honors Ricardo's work with its first Lifetime Achievement Award.;wrap-count:30 ">
                    <a-entity position="3.75 0 0" rotation="0 0 0">
                        <a-image mixin="scale-label" src="images/nominees/ricardo-cabello.jpg" position="1 0 0"
                            width="2" height="2">
                        </a-image>

                        <a-entity
                            link="href: https://www.vuzix.com/Products/AddToCart/157; title: Order Now from Vuzix.com;"
                            position="1.25 -1.56 0.01"></a-entity>

                    </a-entity><!-- Photo Caption -->
                    <!-- Image Panels -->
                </a-text>
            </a-entity>




        </a-entity>

        











        <a-entity id="webxremblem" class="center-zone" position="2 9 -7.4">
            <a-entity position="-2 -2 1.4">
                <!--    <a-sphere color="yellow" height="0.15" radius="0.1"></a-sphere>
            <a-entity mixin="holoprojector"></a-entity>
            -->
                <a-light type="point" color="blue" position="0 1 0"></a-light>
                <a-entity id="holoartproj" visible="true">


                    <a-entity scale="7 7 7" rotation="0 0 0" class="center-obj-zone" static-body position="0 1.25 0"
                        gltf-model="models/emblem.glb"
                        animation="property: object3D.rotation.y; to: 360; easing: linear; dur: 12000; loop: true;"
                        visible="true"></a-entity>
                </a-entity>
            </a-entity>




        </a-entity>

        <a-entity mixin="credit-text" class="credits" id="credits" visible="TRUE" position="0 -0.-11 -13" text="value: "
            color=>
            <a-text position="0 0 0" value="Credits and Info" color="black" width="2"></a-text>

            <a-entity togg-cred mixin="button" class="clickable" position="0 0 0" id="credbutt"
                gltf-model="#buttonmodel"></a-entity>
            <a-entity mixin="credit-text" class="credits" id="credits-1" position="0 0 0" text="value:  
Special thanks to Dr. Keith Chan - This site is drived from ANVROPOMOTRON; color: white; wrapCount: 10"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-2" visible="false" position="0 0 0"
                text="value: Page 2; color: white; wrapCount: 10"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-3" position="0 0 0" visible="false"
                text="value: Page 3; color: white; wrapCount: 10"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-4" position="0 0 0" visible="false"
                text="value: Page 4;"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-5" position="0 0 0" visible="false"
                text="value: Page 5;"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-6" visible="false" position="0 0 0"
                text="value: Page 6; "></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-7" visible="false" position="0 0 0"
                text="value: Page 7; "></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-8" visible="false" position="0 0 0"
                text="value: Page 8"></a-entity>

            <a-entity mixin="credit-text" class="credits" id="credits-8" visible="false" position="0 0 0"
                text="value: PAGE 9"></a-entity>
        </a-entity>

    </a-scene>
</body>

</html>