<script setup>
import { onMounted, reactive } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const postId = route.params.id;

const state = reactive({
  post:[]
})

onMounted(async () => {
  try {
    const response = await axios.get(`http://localhost/belajar.api/get-all-data.php`);
    console.log(response)
    state.post = response.data;
  } catch (error) {
    console.error('Error fetching post:', error);
  }
});
</script>

<template>
  <div>
    <h2>Post Details</h2>
    <p><strong>ID:</strong> {{ post.student_id }}</p>
    <p><strong>Name:</strong> {{ post.student_name }}</p>
    <p><strong>No:</strong> {{ post.student_no }}</p>
    <p><strong>Class:</strong> {{ post.student_class }}</p>
  </div>
</template>
