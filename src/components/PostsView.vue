<script setup>
import axios from 'axios';
import { onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const postId = route.params.id;

const state = reactive({
  post: {}
});

onMounted(async () => {
  try {
    const response = await axios.get(`http://localhost/belajar.api/get-all-data.php?id=${postId}`);
    state.post = response.data;
  } catch (error) {
    console.error("Error while fetching: ", error);
  }
});
</script>

<template>
  <div class="detail-container">
    <h2>🎓 Student Details</h2>
    <div class="detail-card">
      <p><span>Name:</span> {{ state.post.student_name }}</p>
      <p><span>Address:</span> {{ state.post.student_address }}</p>
    </div>
    <RouterLink :to="`/posts`" class="btn">← Return to Posts</RouterLink>
  </div>
</template>

<style scoped>
.detail-container {
  max-width: 600px;
  margin: 40px auto;
  padding: 30px;
  background-color: #fdf6fa;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
  text-align: center;
}

h2 {
  margin-bottom: 25px;
  color: #191b1b;
}

.detail-card {
  background-color: #fff;
  border: 1px solid #f3e8f1;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
}

p {
  margin: 12px 0;
  font-size: 1.1rem;
  color: #333;
}

span {
  font-weight: bold;
  color: #191b1b;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #191b1b;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #191b1b;
}
</style>
