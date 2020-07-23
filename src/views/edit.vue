<template>
  <div class="imageGalary">
    <h3 class="head-title">{{ filename }}</h3>
    <div class="card">
    <div class="single-image">
      <VueCropper v-if="cropOption" ref="cropper" :aspectRatio="16/15" :src="imageBase64fun()" :guides="true" alt="Source Image">
      </VueCropper>
      <v-lazy-image id="image" :style="'filter:'+customStyle" v-if="!cropOption" :src="imageBase64fun()" src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg" />
      <div v-if="cropOption" class="button-lists">
          <button @click="reset" class="btn-outline-sm">reset</button>
          <button @click="cropImage" class="btn-custom-sm">crop</button>
      </div>
    </div>
      <div class="tabs">
        <ul class="tabs-ul">
          <li @click="optionChange('filter')">
            <img src="/assets/images/filter.svg" alt="" /><span>Filter</span>
          </li>
          <li>
            <img src="/assets/images/adjust.svg" alt="" /><span>Adjust</span>
          </li>
          <li @click="optionChange('crop')"><img src="/assets/images/crop.svg" alt="" /><span>Crop</span></li>
        </ul>
      </div>
      <div v-if="cropOption" class="card options">
        <div class="crop-option">
          <div class="crop-item">
            <img src="/assets/images/flip.svg" alt="" /><span>Flip</span>
          </div>
          <div>
            <button class="btn-custom active">None</button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="flipX">
              <img src="/assets/images/flip-h.svg" alt="" /> Flip Horizontally
            </button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="flipY">
              <img src="/assets/images/flip-v.svg" alt="" /> Flip Vertically
            </button>
          </div>
        </div>
        <div class="crop-option">
          <div class="crop-item">
            <img src="/assets/images/rotate.svg" alt="" /><span>Rotate</span>
          </div>
          <div>
            <button class="btn-custom active" @click.prevent="rotate(0)">0 deg</button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="rotate(30)">30 deg</button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="rotate(60)">
              60 deg
            </button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="rotate(90)">
              90 deg
            </button>
          </div>
          <div>
            <button class="btn-custom" @click.prevent="rotate(180)">
              180 deg
            </button>
          </div>
        </div>
        <div class="crop-option">
          <div class="crop-item">
            <img src="/assets/images/ratio.svg" alt="" /><span>Ratio</span>
          </div>
          <div>
            <button class="btn-custom active" @click.prevent="ratio('16/10')">16:9</button>
          </div>
          <div>
            <button class="btn-custom">10:7</button>
          </div>
          <div>
            <button class="btn-custom">
              7:5
            </button>
          </div>
          <div>
            <button class="btn-custom">
              4:3
            </button>
          </div>
          <div>
            <button class="btn-custom">
              5:3
            </button>
          </div>
          <div>
            <button class="btn-custom">
              3:2
            </button>
          </div>
        </div>
      </div>
      <div v-if="filterOption" class="card filter-options">
        <div class="items">
            <div class="item" @click="filterImage(0)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Original</span>
              </div>
            </div>
            <div class="item" @click="filterImage(1)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  style="filter : sepia(0.3) contrast(1.1) brightness(1.1) grayscale(1)"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>GreyScale</span>
              </div>
            </div>
            <div class="item" @click="filterImage(2)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  style="filter: sepia(1);"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Sephia</span>
              </div>
            </div>
            <div class="item" @click="filterImage(3)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  style="filter: invert(2);"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Invert</span>
              </div>
            </div>
            <div class="item" @click="filterImage(4)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  style="filter: saturate(8);"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Dueton</span>
              </div>
            </div>
            <div class="item" @click="filterImage(5)">
              <div class="image">
                <v-lazy-image
                  :src="imageBase64fun()"
                  style="filter: hue-rotate(183deg) saturate(465%);"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Warm</span>
              </div>
            </div>
            <div class="item" @click="filterImage(6)">
              <div class="image">
                <v-lazy-image
                  style="filter: hue-rotate(128deg);"
                  :src="imageBase64fun()"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Cool</span>
              </div>
            </div>
            <div class="item" @click="filterImage(7)">
              <div class="image">
                <v-lazy-image
                  style="filter: drop-shadow(8px 8px 10px grey);"
                  :src="imageBase64fun()"
                  src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
                />
              </div>
              <div class="content">
                <span>Dramatic</span>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="card button-lists">
        <button @click="$router.push('/');" class="btn-outline-lg">Back</button>
        <button @click="save" class="btn-custom-lg">save</button>
    </div>
    <canvas id="myCanvas">
Your browser does not support the HTML5 canvas tag.</canvas>
  </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
export default {
  name: "edit",
  data() {
    return {
      filename: null,
      imageBase64: null,
      setRatio: '16/9',
      filterOption: true,
      cropOption: false,
      customStyle: null,
    };
  },
  created() {
    this.dataFilter();
    // this.$root.$refs.layout = this;
  },
  methods: {
    dataFilter() {
      this.filename = this.$route.params.filename.split("-$dots-").join(".");
    },
    optionChange(option) {
      if (option === "filter") {
        this.filterOption = true;
        this.cropOption = false;
      } else if (option === "crop") {
        this.filterOption = false;
        this.cropOption = true;
      }
    },
    imageBase64fun() {
      if (this.imageBase64 == null) {
        return "galaries/"+this.filename;
      } else {
        return this.imageBase64;
      }
    },
    filterImage(value) {
      if (value === 0) {
        this.customStyle = "None";
      }
      if (value === 1) {
        this.customStyle = "sepia(0.3) contrast(1.1) brightness(1.1) grayscale(1)";
      } else if (value === 2) {
        this.customStyle = "sepia(1)";
      } else if (value === 3) {
        this.customStyle = "invert(2)";
      } else if (value === 4) {
        this.customStyle = "saturate(8)";
      } else if (value === 5) {
        this.customStyle = "hue-rotate(183deg) saturate(465%)";
      } else if (value === 6) {
        this.customStyle = "hue-rotate(128deg)";
      } else if (value === 7) {
        this.customStyle = "drop-shadow(8px 8px 10px grey)";
      }
       window.scrollTo(0,0);
    },
    ratio(value) {
      console.log(value);
    },
    rotate(deg) {
      this.$refs.cropper.rotate(deg);
    },
    flipX() {
      const dom = this.$refs.flipX;
      let scale = dom.getAttribute("data-scale");
      scale = scale ? -scale : -1;
      this.$refs.cropper.scaleX(scale);
      dom.setAttribute("data-scale", scale);
    },
    flipY() {
      const dom = this.$refs.flipY;
      let scale = dom.getAttribute("data-scale");
      scale = scale ? -scale : -1;
      this.$refs.cropper.scaleY(scale);
      dom.setAttribute("data-scale", scale);
    },
    cropImage() {
      this.imageBase64 = this.$refs.cropper.getCroppedCanvas().toDataURL();
      this.optionChange("filter");
      return;
    },
    b64toBlob(dataURI) {
      let byteString = atob(dataURI.split(',')[1]);
      let ab = new ArrayBuffer(byteString.length);
      let ia = new Uint8Array(ab);

      for (let i = 0; i < byteString.length; i++) {
          ia[i] = byteString.charCodeAt(i);
      }
      return new Blob([ab], { type: 'image/jpeg' });
    },
    reset() {
      this.$refs.cropper.reset();
    },
    save() {
        let canvas = document.getElementById("myCanvas");
        let currentImg = document.querySelector("#image");
        let img = new Image();
        canvas.width = currentImg.naturalWidth;
        canvas.height = currentImg.naturalHeight;

        let ctx = canvas.getContext("2d");
        ctx.filter = this.customStyle;
        
        img.onload = function() {
          ctx.drawImage(img, 0, 0);
          upload();
        };
        img.src = this.imageBase64fun();
        var root = this;
        function upload() {
              canvas.toBlob(function (blob) {
                  let formData = new FormData()
                  formData.append("name", root.filename)
                  formData.append("file", blob)
                  axios
                    .post("/update-image.php", formData)
                    .then(response => {
                        if (response.data.status == "success") {
                          alert(response.data.message);
                          window.location.href="/";
                        } else {
                          alert(response.data.message);
                        }
                    })
              })
          }
    },
  },
  components: {
    VueCropper
  },
};
</script>
