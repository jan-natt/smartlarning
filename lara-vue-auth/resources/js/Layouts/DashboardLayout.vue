<template>
    <div class="dashboard">
        <sidebar :role="useRemember.role" />
        <main>
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Sidebar from './Sidebar.vue'
import axios from 'axios'

const user = ref({})

onMounted(async () => {
    const { data } = await axios.get('/api/user')
    user.value = data
})
</script>

<style scoped>
.dashboard {
    display: flex;
}
main {
    flex:1 ;
    padding: 20px;
}
</style>