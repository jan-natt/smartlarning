<template>
  <div class="profile">
    <h2>Profile Settings</h2>
    <form @submit.prevent="updateProfile">
      <input type="text" v-model="user.name" placeholder="Your name" />
      <input type="file" @change="onFileChange" />
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const user = ref({})
const file = ref(null)

onMounted(async () => {
  const { data } = await axios.get('/api/user')
  user.value = data
})

const onFileChange = (e) => {
  file.value = e.target.files[0]
}

const updateProfile = async () => {
  const formData = new FormData()
  formData.append('name', user.value.name)
  if (file.value) formData.append('profile_picture', file.value)
  await axios.post('/api/user/update', formData)
  alert('Profile updated successfully!')
}
</script>
