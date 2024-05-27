<script setup>
import {useUserStore} from "@/stores/auth.js";
import {useRouter} from "vue-router";
import {computed, onMounted, ref} from "vue";

const userStore = useUserStore();
const router = useRouter();

const logout = async () => {
  try {
    await userStore.logoutUser();
    await router.push("/login");
  } catch (error) {
    console.log(error);
  }
}

const users = computed(() => userStore.getListUsers);

onMounted(async () => {
  await userStore.getAllUsers();
});

const user = computed(() => userStore.getUser.role);

</script>

<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item" v-if="user === 'admin'">
              <RouterLink to="/dashboard" class="nav-link">Dashboard</RouterLink>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                 aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" @click="logout" href="javascript:void(0);">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <table class="table mt-5">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(user,index) in users" :key="index">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.role }}</td>
      </tr>
      </tbody>
    </table>
  </div>

</template>

<style scoped>

</style>