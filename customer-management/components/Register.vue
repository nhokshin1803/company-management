<template>
  <b-modal id="register-dialog" title="Register" v-model="isShowRegister">
    <div class="form-content">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              placeholder="Your Name *"
              v-model="newUser.fullname"
            />
          </div>
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              placeholder="Username *"
              v-model="newUser.username"
            />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              placeholder="Your Password *"
              v-model="newUser.password"
            />
          </div>
        </div>
      </div>
    </div>
    <template #modal-footer>
      <div class="w-100">
        <button
          class="btn btn-success center"
          variant="primary"
          @click="registerUser"
        >
          Submit
        </button>
      </div>
    </template>
  </b-modal>
</template>
<script>
export default {
  $auth: false,
  props: {
    showRegister: Boolean
  },
  data() {
    return {
      newUser: {
        fullname: "",
        username: "",
        password: "",
        is_admin: 0
      }
    };
  },
  methods: {
    async registerUser() {
      let that = this;
      // vì chúng ta không khai báo API register trong phần config nên phải dùng axios để gọi đến API
      await this.$axios.post("register", this.newUser).then(resp => {
        that.$emit("showRegisterFalse");
        alert("Register successfully");
      });
    }
  },

  computed: {
    isShowRegister() {
      return this.showRegister;
    }
  }
};
</script>
