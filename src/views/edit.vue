<template>
  <div class="imageGalary">
    <h3 class="head-title">{{ filename }}</h3>
    <div class="card">
    <div class="single-image">
      <VueCropper ref="cropper" :aspectRatio="setRatio" :src="'/galaries/'+filename" :guides="true" alt="Source Image">
      </VueCropper>
      <div class="button-lists">
          <button @click="reset" class="btn-outline-sm">reset</button>
          <!-- <button @click="cropImage" class="btn-custom-sm">crop</button> -->
      </div>
    </div>
      <div class="tabs">
        <ul class="tabs-ul">
          <li>
            <img src="/assets/images/filter.svg" alt="" /><span>Filter</span>
          </li>
          <li>
            <img src="/assets/images/adjust.svg" alt="" /><span>Adjust</span>
          </li>
          <li><img src="/assets/images/crop.svg" alt="" /><span>Crop</span></li>
        </ul>
      </div>
      <div class="card options">
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
    </div>
    <div class="card button-lists">
        <button class="btn-outline-lg">Back</button>
        <button @click="save" class="btn-custom-lg">save</button>
    </div>
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
      setRatio: '16/9'
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
    ratio(value) {
      this.setRatio = value;
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
      let root = this;
      this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
          let formData = new FormData()
          formData.append("name", root.filename)
          formData.append("file", blob)
          axios
            .post("/update-image.php", formData)
            .then(response => {
              console.log(response.data)
            })
      })
    },
    reset() {
      this.$refs.cropper.reset();
    },
    save() {
      this.cropImage();
    }
  },
  components: {
    VueCropper
  },
};
</script>
