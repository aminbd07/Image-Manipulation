<template>
  <div class="imageGalary">
    <h3 class="head-title">Media Library</h3>
    <div class="card">
      <div class="items-count">{{ Object.keys(images).length }} Items</div>
      <div class="items">
        <div
          class="item"
          @click="openEdit(image)"
          v-for="(image, index) in images"
          :key="'image-' + index"
        >
          <div class="image">
            <v-lazy-image
              :src="'galaries/' + image"
              src-placeholder="https://cdn-images-1.medium.com/max/80/1*xjGrvQSXvj72W4zD6IWzfg.jpeg"
            />
          </div>
          <div class="content">
            <span>{{ image }}</span>
          </div>
        </div>
      </div>
    </div>
    <br />
    <br />
    <div class="upload-control">
      <div class="bold-txt">Upload Image</div>
      <div
        class="upload-fields card"
        :class="{ dragging: isDragging }"
        @dragenter="OnDragEnter"
        @dragleave="OnDragLeave"
        @dragover.prevent
        @drop="onDrop"
      >
        <div class="progress-bar" v-if="uploading">
          <progress max="100" :value.prop="uploadPercentage"></progress>
        </div>
        <div else class="content">
          <img src="assets/images/server.svg" />
          <span
            >Drag and Drop or
            <span class="highlighter">Browse for Files</span></span
          >
          <input type="file" @change="updateFiles" multiple />
        </div>
      </div>
    </div>
    <vue-snotify></vue-snotify>
  </div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      isDragging: false,
      uploading: false,
      dragCount: 0,
      uploadPercentage: 0,
      images: [],
      uploaders: [],
    };
  },
  created() {
    this.getImages();
  },
  methods: {
    updateFiles(e) {
      const files = e.target.files;
      Array.from(files).forEach((file) => this.addImage(file));
      this.upload();
    },
    OnDragEnter(e) {
      e.preventDefault();
      this.dragCount++;
      this.isDragging = true;
    },
    OnDragLeave(e) {
      e.preventDefault();
      this.dragCount--;
      if (this.dragCount <= 0) this.isDragging = false;
    },
    onDrop(e) {
      e.preventDefault();
      e.stopPropagation();
      this.isDragging = false;

      const files = e.dataTransfer.files;
      Array.from(files).forEach((file) => this.addImage(file));
      this.upload();
    },
    addImage(file) {
      if (!file.type.match("image.*")) {
        console.log(`${file.name} is not a image !!`);
      }
      this.uploaders.push(file);
    },
    upload() {
      this.uploading = true;
      let formData = new FormData();
      this.uploaders.forEach((file) => {
        formData.append("images[]", file, file.name);
      });
      axios
        .post("/save-image.php", formData, {
          header: {
            "Content-Type": "multipart/form-data",
          },
          onUploadProgress: function(progressEvent) {
            this.uploadPercentage = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(this),
        })
        .then((response) => {
          if (response.data.status == "success") {
            this.$snotify.success(response.data.message);
          } else {
            this.$snotify.error(response.data.message);
          }
          this.uploaders = [];
          this.uploading = false;
          this.getImages();
        });
    },
    getImages() {
      axios.post("/get-images.php").then((response) => {
        this.images = response.data;
      });
    },
    openEdit(image) {
      const filename = image.split(".").join("-$dots-");
      this.$router.push("edit/" + filename);
    },
  },
};
</script>
