<template>
  <div class="main-container">
    <v-card width="400">
      <v-card-title class="title">Register</v-card-title>
      <v-card-text>
        <v-form ref="form" lazy-validation>
          <div class="avatar">
            <input
              ref="file_input"
              type="file"
              class="hidden"
              accept="image/x-png,image/gif,image/jpeg"
              @change="onFileChange($event.target.files)"
            />
            <v-avatar size="90">
              <img
                v-if="image_base64" 
                :src="image_base64" 
                alt="John" 
                @click="triggerUpload"
                />
                <v-icon  @click="triggerUpload" size="80" v-else>
                  mdi-account-circle
                </v-icon>
            </v-avatar>
          </div>
          <v-text-field
            v-model="payload.first_name"
            :rules="[() => !!payload.first_name || '']"
            dense
            outlined
            placeholder="first name"
            label="first name"
          >
          </v-text-field>

          <v-text-field
            v-model="payload.last_name"
            :rules="[() => !!payload.last_name || '']"
            dense
            outlined
            placeholder="Last name"
            label="Last name"
          >
          </v-text-field>
          <v-text-field
            v-model="payload.phone"
            :rules="[() => !!payload.phone || '']"
            dense
            outlined
            placeholder="Phone"
            label="Phone"
          >
          </v-text-field>
          <v-menu
            v-model="menu2"
            :close-on-content-click="false"
            :nudge-right="0"
            :nudge-bottom="40"
            transition="scale-transition"
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                outlined
                dense
                v-model="payload.birthday"
                :rules="[() => !!payload.birthday || '']"
                label="Birthday"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="payload.birthday"
              @input="menu2 = false"
            ></v-date-picker>
          </v-menu>
          <v-text-field
            v-model="payload.email"
            :rules="[() => !!payload.email || '']"
            dense
            outlined
            placeholder="Email"
            label="Email"
          >
          </v-text-field>
          <v-text-field
            v-model="payload.password"
            :rules="[() => !!payload.password || '']"
            dense
            outlined
            placeholder="Password"
            label="Password"
            type="password"
          >
          </v-text-field>
          <v-text-field
            v-model="payload.c_password"
            :rules="[() => payload.c_password == payload.password || '']"
            dense
            outlined
            placeholder="Confirm Password"
            label="Confirm Password"
            type="password"
          >
          </v-text-field>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" @click="$router.push({name: 'login'})">Cancel</v-btn>
        <v-btn color="primary" @click="save">Save</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      menu2: false,
      payload: {},
      image_base64:''
    };
  },
  methods: {
    save() {
      this.payload.image_base64 = this.image_base64
      console.log(this.payload,"payload")
      if (!this.$refs.form.validate()) return;
       axios.get(`/admin-api/check-email?email=${this.payload.email}`).then( async({data})=>{
        if(!data){
          axios.post(`/admin-api/register`,this.payload).then(({data})=>{
            this.$router.push({name: 'login'})
          });
        }
       });
    },
    triggerUpload() {
      this.$refs.file_input.click();
    },

    async onFileChange(file) {
      this.isUpload = true;
      let imageFile = file[0];
      let temp = {};
      if (file.length > 0) {
        if (!imageFile.type.match("image.*")) {
          this.errorDialog = true;
          this.errorText = "Please choose an image file";
        } else {
          let imageURL = URL.createObjectURL(imageFile);
          console.log(imageFile.name, "imageURL");
          this.image_base64 = await this.createImageBase64(imageFile);
        }
      }
      this.isUpload = false;
    },
    createImageBase64(file) {
      var reader = new FileReader();

      return new Promise((resolve, reject) => {
        reader.onload = (e) => {
          let res = e.target.result;
          resolve(res);
        };
        reader.readAsDataURL(file);
      });
    },
  },
  created() {},
};
</script>
<style lang="scss" scoped>
.main-container {
  display: grid;
  place-items: center;
  height: 100vh;

  .title {
    justify-content: center;
  }
  .avatar {
    display: flex;
    justify-content: center;
    margin-bottom: 23px;

    .hidden {
      display: none;
    }
  }
}
</style>