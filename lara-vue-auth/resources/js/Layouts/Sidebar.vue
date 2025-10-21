<template>
  <aside class="sidebar">
    <ul v-if="role === 'admin'">
      <li><router-link to="/admin/dashboard">Admin Dashboard</router-link></li>
      <li><router-link to="/admin/users">Manage Users</router-link></li>
    </ul>

    <ul v-else-if="role === 'teacher'">
      <li><router-link to="/teacher/dashboard">Teacher Dashboard</router-link></li>
      <li><router-link to="/teacher/courses">My Courses</router-link></li>
    </ul>

    <ul v-else>
      <li><router-link to="/student/dashboard">Student Dashboard</router-link></li>
      <li><router-link to="/student/courses">My Enrollments</router-link></li>
    </ul>
  </aside>
</template>

<script setup>
defineProps({ role: String })
</script>

<style scoped>
.sidebar {
  width: 250px;
  background: #222;
  color: #fff;
  height: 100vh;
  padding: 20px;
}
.sidebar a {
  color: white;
  text-decoration: none;
}
</style>
