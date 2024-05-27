<script setup>
import {useUserStore} from "@/stores/auth.js";
import {reactive, ref} from "vue";
import {useRouter, useRoute} from "vue-router";

const router = useRouter();
const route = useRoute();
const userStore = useUserStore();

const error = reactive({
  email: '',
  password: ''
});

const errorLogin = ref("");
const successLogin = ref("");
const dismissError = () => {
  errorLogin.value = "";
};

const validate = () => {
  error.email = "";
  error.password = "";
  error.email = data.email ? "" : "Email không được để trống";
  error.password = data.password ? "" : "Mật khẩu không được để trống";
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!data.email.match(regex)) {
    error.email = "Email không hợp lệ";
  }
  if (data.password.length < 6) {
    error.password = "Mật khẩu phải có ít nhất 6 ký tự";
  } else if (data.password.length > 25) {
    error.password = "Mật khẩu không được quá 25 ký tự";
  }
  return !(error.email || error.password);
};

const data = reactive({
  email: '',
  password: ''
});
const login = async () => {
  try {
    if (!validate()) {
      return;
    }
    await userStore.loginUser(data);
    successLogin.value = "Đăng nhập thành công";
    if (successLogin.value) {
      dismissError();
    }
    setTimeout(() => {
      router.push(route.query.redirect ?? "/");
    }, 1000);
  } catch (error) {
    errorLogin.value = error.response.data.errors.error_message;
  }
};
</script>

<template>
  <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
          <div v-if="errorLogin" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ errorLogin }}
            <button
                type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                @click="dismissError"></button>
          </div>
          <div v-if="successLogin" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ successLogin }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="card mb-0">
            <div class="card-body">
              <form @submit.prevent="login">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email"
                         id="email" v-model="data.email"
                         placeholder="nhập email" aria-describedby="emailHelp">
                  <div v-if="error.email" class="text-danger">{{ error.email }}</div>
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Mật khẩu</label>
                  <input type="password" class="form-control" name="password"
                         placeholder="nhập mật khẩu" v-model.trim="data.password" id="password">
                  <div v-if="error.password" class="text-danger">{{ error.password }}</div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Đăng nhập
                </button>
              </form>
              <div class="d-flex justify-content-center">
                <RouterLink to="/register" class="text-decoration-none text-dark">
                  <span class="text-dark me-2">Chưa có tài khoản?</span><span class="text-primary">Đăng ký ngay</span>
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