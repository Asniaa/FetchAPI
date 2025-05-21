<script setup>
import { IonPage, IonContent } from '@ionic/vue';
import { onMounted, reactive } from 'vue';
import { RouterLink } from 'vue-router';
import axios from 'axios';

const state = reactive({
  posts: []
});

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost/belajar.api/get-all-data.php');
    state.posts = response.data;
  } catch (error) {
    console.error('Error fetching posts:', error);
  }
});

const deletePost = async (postId) => {
  try {
    const confirmDelete = window.confirm('Are you sure you want to delete this post?');
    if (confirmDelete) {
      await axios.delete('http://localhost/belajar.api/delete-data.php', {
        data: { student_id: postId }
      });
      state.posts = state.posts.filter(post => post.student_id !== postId);
    }
  } catch (error) {
    console.error("Error deleting post:", error);
  }
};
</script>

<template>
  <ion-page>
    <ion-content class="ion-padding">
      <div class="table-container">
        <h1>📚 All Posts</h1>

        <nav>
          <RouterLink to="/" class="home">🏠 Home</RouterLink>
          <RouterLink to="/posts/add" class="add">➕ Add Post</RouterLink>
        </nav>

        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>ID</th>
              <th>Nama</th>
              <th>Class</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(post, index) in state.posts" :key="post.student_id">
              <td class="center">{{ index + 1 }}</td>
              <td class="center">{{ post.student_id }}</td>
              <td>{{ post.student_name }}</td>
              <td>{{ post.student_class || 'N/A' }}</td>
              <td class="center actions">
                <RouterLink :to="`/posts/${post.student_id}`" class="lihat">Lihat</RouterLink>
                <RouterLink :to="`/posts/edit/${post.student_id}`" class="edit">Edit</RouterLink>
                <button @click="deletePost(post.student_id)" class="hapus">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </ion-content>
  </ion-page>
</template>

<style scoped>
.table-container {
  max-width: 900px;
  margin: auto;
  padding: 20px;
}

.table-container h1 {
  text-align: center;
  color: #334155;
}

nav {
  margin-bottom: 20px;
}

nav a {
  text-decoration: none;
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  margin-right: 10px;
  font-weight: bold;
}

nav .home {
  background-color: #a7a7e9;
}

nav .add {
  background-color: #83e9e9;
}

table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
  border-radius: 8px;
  overflow: hidden;
}

thead {
  background-color: #f1f5f9;
}

thead th {
  padding: 10px;
  text-align: center;
  color: #1e293b;
}

tbody td {
  padding: 10px;
  border-top: 1px solid #e2e8f0;
}

tbody tr:nth-child(even) {
  background-color: #f8fafc;
}

tbody tr:nth-child(odd) {
  background-color: #ffffff;
}

td.center {
  text-align: center;
}

.actions a,
.actions button {
  padding: 6px 10px;
  border-radius: 5px;
  text-decoration: none;
  color: #fff;
  font-size: 14px;
  margin-right: 6px;
}

.actions .lihat {
  background-color: #55d8c9;
}

.actions .edit {
  background-color: #7ca2e0;
}

.actions .hapus {
  background-color: #ef4444;
  border: none;
  cursor: pointer;
}
</style>
