<script setup>
import {useUserStore} from "@/stores/auth.js";
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter();
const userStore = useUserStore();

const errors = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: ''
});

const data = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: ''
});

const errorRegister = ref("");
const successRegister = ref("");

const dismissError = () => {
  errorRegister.value = "";
};

const validated = () => {
  errors.email = "";
  errors.password = "";
  errors.confirmPassword = "";
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!data.email.match(regex)) {
    errors.email = "Email không hợp lệ";
  }
  if (data.email === "") {
    errors.email = "Email không được để trống";
  }
  if (data.password === "") {
    errors.password = "Mật khẩu không được để trống";
  }
  if (data.confirmPassword === "") {
    errors.confirmPassword = "Xác nhận mật khẩu không được để trống";
  }
  if (data.password !== data.confirmPassword) {
    errors.confirmPassword = "Mật khẩu không khớp";
  }
  if (data.password.length < 6) {
    errors.password = "Mật khẩu phải có ít nhất 6 ký tự";
  } else if (data.password.length > 25) {
    errors.password = "Mật khẩu không quá 25 ký tự";
  }
  return !(errors.name || errors.email || errors.password || errors.confirmPassword);
}

const register = async () => {
  try {
    if (!validated()) {
      return;
    }
    console.log(data);
    await userStore.registerUser(data);
    successRegister.value = "Đăng ký thành công";
    dismissError();
    setTimeout(() => {
      router.push("/login");
    }, 1000);
  } catch (error) {
    errorRegister.value = error.response.data.errors.error_message;
  }
};
</script>

<template>
  <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
          <div v-if="errorRegister" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ errorRegister }}
            <button
                type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                @click="dismissError"></button>
          </div>
          <div v-if="successRegister" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ successRegister }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="card mb-0">
            <div class="card-body">
              <form @submit.prevent="register">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name"
                         id="name" v-model="data.name"
                         placeholder="nhập email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email"
                         id="email" v-model="data.email"
                         placeholder="nhập email" aria-describedby="emailHelp">
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Mật khẩu</label>
                  <input type="password" class="form-control" name="password" v-model.trim="data.password"
                         placeholder="nhập mật khẩu" id="password">
                </div>
                <div class="mb-4">
                  <label for="confirmation_password" class="form-label">Nhập Lại Mật khẩu</label>
                  <input type="password" class="form-control" name="confirmation_password"
                         v-model.trim="data.confirmPassword"
                         placeholder="nhập lại mật khẩu" id="confirmation_password">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Đăng nhập
                </button>
              </form>
              <div class="d-flex justify-content-center">
                <RouterLink to="/login" class="text-decoration-none text-dark">
                  <span class="text-dark me-2">Đã có tài khoản?</span><span class="text-primary">Đăng nhập ngay</span>
                </RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>