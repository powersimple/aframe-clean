AFRAME.registerComponent('device-set', {
    init: function () {
        var sceneEl = document.querySelector('a-scene');
        var tablestand = sceneEl.querySelectorAll('.table');
        var standup = sceneEl.querySelectorAll('.standup');
        var rig = document.querySelector('#rig');
        if (AFRAME.utils.device.isMobile() === true) { // Smartphone Mode
            sceneEl.setAttribute("vr-mode-ui", "enabled", "false");
            rig.setAttribute("movement-controls", "speed", 0.15);
            document.querySelector('#GL-SP').setAttribute("visible", "true");
            document.querySelector('#SMH-SP').setAttribute("visible", "true");
            for (let each of tablestand) {
                each.setAttribute('animation', {
                    property: 'position.y',
                    to: 0.3,
                    dur: 5000
                });
            }
            for (let each of standup) {
                each.removeAttribute('dynamic-body');
                each.removeAttribute('grabbable');
                each.setAttribute('static-body');
                each.setAttribute('rotation', {
                    z: 90
                });
                each.dispatchEvent(new CustomEvent("standtrigger"));
            }
        } else if (AFRAME.utils.device.checkHeadsetConnected() === true) { // VR Mode
            document.querySelector('#GL-VR').setAttribute("visible", "true");
            document.querySelector('#SMH-VR').setAttribute("visible", "true");
            rig.setAttribute("movement-controls", "speed", 0.10);
        } else if (AFRAME.utils.device.checkHeadsetConnected() === false) { // PC Mode
            document.querySelector('#GL-PC').setAttribute("visible", "true");
            document.querySelector('#SMH-PC').setAttribute("visible", "true");
            rig.setAttribute("movement-controls", "speed", 0.15);
            for (let each of tablestand) {
                each.setAttribute('animation', {
                    property: 'position.y',
                    to: 0.3,
                    dur: 5000,
                    delay: 50
                });
            }
            for (let each of standup) {
                each.removeAttribute('dynamic-body');
                each.removeAttribute('grabbable');
                each.setAttribute('static-body');
                each.setAttribute('rotation', {
                    z: 90
                });
                each.dispatchEvent(new CustomEvent("standtrigger"));
            }
        }
    }
})


AFRAME.registerComponent('thumbstick-logging', {
    init: function () {
        this.el.addEventListener('thumbstickmoved', this.logThumbstick);
    },
    logThumbstick: function (evt) {
        console.log("detevt.detail")
        if (evt.detail.y > 0.95) {
            console.log("DOWN");
        }
        if (evt.detail.y < -0.95) {
            console.log("UP");
        }
        if (evt.detail.x < -0.95) {
            console.log("LEFT");
        }
        if (evt.detail.x > 0.95) {
            console.log("RIGHT");
        }
    }
});

AFRAME.registerComponent('rotation-reader', {
    /**
     * We use IIFE (immediately-invoked function expression) to only allocate one
     * vector or euler and not re-create on every tick to save memory.
     */
    tick: (function () {
        var position = new THREE.Vector3();
        var quaternion = new THREE.Quaternion();
    //    console.log(position, quaternion)
        return function () {
            this.el.object3D.getWorldPosition(position);
            this.el.object3D.getWorldQuaternion(quaternion);
            // position and rotation now contain vector and quaternion in world space.
        };
    })
});

AFRAME.registerComponent('loadsvg', {
    init: function () {
        let canvas = document.getElementById('my-canvas')

        let ctx = canvas.getContext('2d');
        var img = new Image();
        img.onload = () => {
            //ctx.fillStyle = "rgba(255, 255, 255, 0.0)"; ctx.fillRect(0, 0, 256, 256);
            ctx.drawImage(img, 0, 0, 256, 256);

            let mesh = this
                .el
                .getObject3D("mesh")
            var texture = new THREE.Texture(canvas);
            texture.needsUpdate = true;

            var material = new THREE.MeshBasicMaterial({
                map: texture
            });

            let tmp = mesh.material
            mesh.material = material
            tmp.dispose()
        }
        img.src = "images/logo/XRIgnite-Emblem.svg";

    }
})

AFRAME.registerComponent("plane-hit", { // Manual occlusion zones
    init: function () {
        sceneEl = document.querySelector('a-scene');
        var el = this.el;
        var scale1 = sceneEl.querySelectorAll(".scale-zone");
        var scale2 = sceneEl.querySelectorAll(".scale-zone-2");
        var czone = sceneEl.querySelectorAll(".center-zone");
        var gzone = sceneEl.querySelectorAll(".grab-zone");
        var bzone = sceneEl.querySelectorAll(".burial-zone");
        var gzoneobjs = sceneEl.querySelectorAll(".grab-obj-zone");
        var czoneobjs = sceneEl.querySelectorAll(".center-obj-zone");
        var grabcheck = 0;
        var centercheck = 0;
        var scalecheck = 0;
        var burialcheck = 0;
        var visiswitch = function (zone, toggle) {
            for (let each of zone) {
                each.object3D.visible = toggle;
            }
        }
        var visidistanceswitch = function (zone, toggle) {
            for (let each of zone) {
                let poss = each.getAttribute('position.x');
                if (poss <= 2) {
                    each.object3D.visible = toggle;
                }
            }
        }

        var zonechecker = function () {
            var list = el.components['aabb-collider'].intersectedEls;
            for (let each of list) {
                console.log(list);
                if (each.id == "just-grab") { // Turn off Scale Model Hall and Centerpiece or not when user is inside Grab Lab
                    console.log("just-grab entered");
                    grabcheck++;
                }
                if (each.id == "just-center") { // Turn off parts of Scale Model Hall and Grab Lab when user is inside centerpiece area
                    console.log("just-center entered");
                    centercheck++;
                }
                if (each.id == "just-scale") { // Turn off parts of Grab Lab when user is inside Scale Model Hall area
                    console.log("just-scale entered");
                    scalecheck++;
                }
                if (each.id == "just-burial") { // Turn off parts of Burial Chamber when user is inside Scale Model Hall area
                    console.log("just-burial entered");
                    burialcheck++;
                }
            }
            if (grabcheck == 1) {
                console.log("grab on");
                visiswitch(gzone, true);
                visiswitch(gzoneobjs, true);
                grabcheck = 0;
            } else {
                console.log("grab off");
                visiswitch(gzone, false);
                visidistanceswitch(gzoneobjs, false);
            }
            if (centercheck == 1) {
                console.log("center on");
                visiswitch(czone, true);
                visiswitch(czoneobjs, true);
                centercheck = 0;
            } else {
                console.log("center off");
                visiswitch(czone, false);
                visidistanceswitch(czoneobjs, false);
            }
            if (scalecheck == 1) {
                console.log("scale on");
                visiswitch(scale1, true);
                scalecheck = 0;
            } else {
                console.log("scale off");
                visiswitch(scale1, false);
            }
            
        }


        el.addEventListener("hitstart", function (evt) {
            zonechecker();
        }) // Hitstart end

        el.addEventListener("hitend", function (evt) {
            zonechecker();
            // Hitend end     

        })
    }
})

// Controller Teleport Button Listeners
AFRAME.registerComponent("buttons", {
    init: function () {
        var el = this.el;
        var binder = function (butt, emits) {
            el.addEventListener(butt, function (e) {
                el.emit(emits);
            });
        }
        binder("xbuttondown", "teleportstart");
        binder("xbuttonup", "teleportend");
        binder("abuttondown", "teleportstart");
        binder("abuttonup", "teleportend");
        binder("bbuttondown", "teleportstart");
        binder("bbuttonup", "teleportend");
        binder("ybuttondown", "teleportstart");
        binder("ybuttonup", "teleportend");
    }
})

// Scale Model Hall and Burial Chamber Toggle Buttons
AFRAME.registerComponent("grab-panels", {
    init: function () {
        var grabpanel = function (grabbutt, grabset) {
            document.getElementById(grabbutt).addEventListener("grab-start", function (evt) {
                var cent = document.querySelector(grabset);
                cent.setAttribute("visible", !cent.getAttribute("visible"));
            })
        }

        /*
        grabpanel("centerbutt", "#centerpiece-tit"); 
        grabpanel("gorillabutt", "#stand1-tit");
        grabpanel("rhesusbutt", "#stand2-tit");
        grabpanel("gibbonbutt", "#stand3-tit");
        grabpanel("orangbutt", "#stand4-tit");
        grabpanel("notharctusbutt", "#stand5-tit");
        grabpanel("howlerbutt", "#stand6-tit");
        grabpanel("megaladapisbutt", "#stand7-tit");
        grabpanel("tarsierbutt", "#stand8-tit");
        grabpanel("burialbuttinfo", "#james-tit");
        */

    }
})

// Credits Flipper
AFRAME.registerComponent("togg-cred", {
    init: function () {
        var el = this.el;
        var counter = 0;
        var creditslist = document.getElementsByClassName("credits");
        el.addEventListener("grab-start", function (evt) {
            for (let each of creditslist) {
                each.setAttribute("visible", false);
            }
            counter++;
            if (counter > 7) { // Value is total panels minus one
                counter = 0;
            }
            creditslist[counter].setAttribute("visible", true);
        })
    }
})
window.addEventListener('load', (event) => {

   // console.log('page is fully loaded');
}, false);

// VR Grab Lab Grabbing Function
AFRAME.registerComponent("item-grab", {
    init: function () {
        sceneEl = document.querySelector('a-scene');
        var grabtrig = function (grabitem, grabinfo, grabtable, grabholo, grabproj, grabmodel, grabrotate = "0 0 0", grabscale = "5 5 5", grabposition = "0 1 0") {
          //  console.log(grabitem, grabinfo, grabtable, grabholo, grabproj, grabmodel)
            document.getElementById(grabitem).addEventListener("grab-start", function (evt) {
                
                if (document.getElementById(grabinfo).getAttribute('visible') == true) {
                    console.log("infotrue", grabitem, grabinfo, grabtable, grabholo, grabproj, grabmodel)
                    for (let each of sceneEl.querySelectorAll(grabtable)) { // Turn off everything
                        each.setAttribute("visible", false);
                    }
                    document.getElementById(grabproj).setAttribute("visible", false);

                    // document.getElementById(grabholo).setAttribute("visible", false);
                } else {
                    console.log("info", grabitem, grabinfo, grabtable, grabholo, grabproj, grabmodel)
                    for (let each of sceneEl.querySelectorAll(grabtable)) {
                        each.setAttribute("visible", false);
                    }
                    document.getElementById(grabproj).setAttribute("visible", true);
                    document.getElementById(grabinfo).setAttribute("visible", true);
                    document.getElementById(grabholo).setAttribute("visible", true);
                    document.getElementById(grabholo).setAttribute("gltf-model", grabmodel);
                    document.getElementById(grabholo).setAttribute("rotation", grabrotate);
                    document.getElementById(grabholo).setAttribute("scale", grabscale);
                    document.getElementById(grabholo).setAttribute("position", grabposition);
                }
            })
        }
/*
        //The Poly Award
      grabtrig("poly-grab", "poly-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        //Single User Experience
       grabtrig("sue-grab", "sue-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

       // Multi-user experience
        grabtrig("mue-grab", "mue-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)


        //GAME OF THE YEAR
         grabtrig("goty-grab", "goty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        //Entertainment OF THE YEAR
        grabtrig("eeoty-grab", "eeoty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        //Education OF THE YEAR
        grabtrig("edoty-grab", "edoty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        //Developer OF THE YEAR
       grabtrig("doty-grab", "doty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        //Innovation of the year
        grabtrig("ioty-grab", "ioty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

       
        //Framework OF THE YEAR
        grabtrig("foty-grab", "foty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)

        grabtrig("soty-grab", "soty-title", ".art-text", "holoartifact", "holoartproj", "models/emblem.glb", undefined, "2 2 2", undefined)


//Lifetime Achievements Award
grabtrig("oa-grab", "oa-title", ".art-text", "holoartifact", "holoartproj", "images/glb/", undefined, "2 2 2", undefined);

        //Lifetime Achievements Award
        grabtrig("ltaa-grab", "ltaa-title", ".art-text", "holoartifact", "holoartproj", "images/glb/", undefined, "2 2 2", undefined);
        */
    }
})


// Anti-Drop Protection
AFRAME.registerComponent("anti-drop", {
    init: function () {
        sceneEl = document.querySelector('a-scene');
        this.grabbablelist = sceneEl.getElementsByClassName("grabbable");
        this.tick = AFRAME.utils.throttleTick(this.tick, 3000, this);
    },
    dropcheck: function () {
        for (let each of this.grabbablelist) {
            let poss = each.getAttribute('position');
            let area = (poss.x + 1) * (poss.z + 1);
            let absarea = Math.abs(area)
            if (poss.y <= 0.1 && absarea <= 5) {
                console.log(each.object3D.position);
             //   each.object3D.position.set(0, 1.4, 0);
                each.components['dynamic-body'].syncToPhysics(); // This makes the position official
            }
        }
    },
    tick: function (t, dt) { // Tick function magic
        this.dropcheck();
    },

})

AFRAME.registerComponent("nomination-link", {
    init: function () {
        sceneEl = document.querySelector('a-scene');
        this.linklist = sceneEl.getElementsByClassName("ext-link");
        console.log("link",this.linklist)
         for (let each of this.linklist) {
                console.log("link",each.attributes.link.nodeValue)
                each.addEventListener('click', function (evt) {
                    
                  console.log('I was clicked at: ',each.attributes.link.nodeValue);
            });
        }
        //this.tick = AFRAME.utils.throttleTick(this.tick, 3000, this);
    },
    link: function () {
      console.log('link function')
    }

})
