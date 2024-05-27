<script setup>
import {useUserStore} from "@/stores/auth.js";
import {computed, onMounted, reactive} from "vue";

const userStore = useUserStore();

const user = computed(() => userStore.getUser);

onMounted(async () => {
  await userStore.getAllUsers();
});

const users = computed(() => userStore.getListUsers);

const data = reactive({
  id: "",
  name: "",
  email: "",
});

const dataCreate = reactive({
  name: "",
  email: "",
});

const edit = async (id) => {
  const user = users.value.find((user) => user.id === id);
  if (user) {
    data.id = user.id;
    data.name = user.name;
    data.email = user.email;
  }
}

const update = async () => {
  try {
    await userStore.updateUser(data);
    data.id = "";
    data.name = "";
    data.email = "";
  } catch (e) {
    console.log(e);
  }
}

const destroy = async (id) => {
  try {
    await userStore.deleteUser(id);
  } catch (e) {
    console.log(e);
  }
}

const createUser = async () => {
  try {
    await userStore.createUser(dataCreate);
    dataCreate.name = "";
    dataCreate.email = "";
  } catch (e) {
    console.log(e);
  }
}
</script>

<template>
  <div class="container">
    <div>
      <h1>Admin Dashboard</h1>
      <p>Welcome,{{ user.name }}</p>
    </div>
    <table class="table">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">Action</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(user,index) in users" :key="index">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.role }}</td>
        <td>
          <button class="btn btn-primary me-3" @click="edit(user.id)">Edit</button>
          <button class="btn btn-danger" @click="destroy(user.id)">Delete</button>
        </td>
      </tr>
      </tbody>
    </table>
    <div class="row">
      <form class="form mt-5" @submit.prevent="update">
        <p>Update form</p>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" v-model="data.name">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" aria-describedby="email" v-model="data.email">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
      <form class="form mt-5" @submit.prevent="createUser">
        <p>Create form</p>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" v-model="dataCreate.name">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" aria-describedby="email" v-model="dataCreate.email">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.form {
  border: 0.5px solid black;
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 5px;
  width: 40%;
  margin: 0 auto;
}

</style>
