<script setup>
import axios from 'axios';
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = reactive({
  student_id: '',
  student_no: '',
  student_name: '',
  student_class: ''
});

const handleSubmit = async () => {
  try {
    const response = await axios.post('http://localhost/belajar.api/insert-data.php', {
      student_no: form.student_no,
      student_name: form.student_name,
      student_class: form.student_class
    });

    console.log('Data berhasil ditambahkan:', response.data);
    router.push('/posts');
  } catch (error) {
    console.error("Gagal menambahkan data:", error);
  }
};
</script>

<template>
  <div class="form-wrapper">
    <RouterLink to="/posts" class="btn back-btn">← Return to Posts</RouterLink>

    <form @submit.prevent="handleSubmit">
      <h2>➕ Add New Student</h2>

      <label for="student_id">ID</label>
      <input 
        v-model="form.student_id" 
        type="text" 
        id="student_id" 
        placeholder="Masukkan ID (optional)"
      />

      <label for="no">No</label>
      <input 
        v-model="form.student_no" 
        type="text" 
        id="no" 
        placeholder="Masukkan Nomor"
        required
      />

      <label for="student_name">Nama</label>
      <input 
        v-model="form.student_name" 
        type="text" 
        id="student_name" 
        placeholder="Masukkan Nama"
        required
      />

      <label for="student_class">Class</label>
      <input 
        v-model="form.student_class" 
        type="text" 
        id="student_class" 
        placeholder="Masukkan Kelas"
        required
      />

      <button type="submit" class="btn submit-btn">Submit</button>
    </form>
  </div>
</template>

<style scoped>
.form-wrapper {
  max-width: 500px;
  margin: 40px auto;
  background-color: #f8fafc;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #334155;
}

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 6px;
  font-weight: 600;
  color: #475569;
}

input {
  margin-bottom: 16px;
  padding: 10px 12px;
  font-size: 1rem;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  transition: border 0.2s ease;
}

input:focus {
  outline: none;
  border-color: #6366f1;
  background-color: #fff;
}

.btn {
  padding: 10px 14px;
  border: none;
  border-radius: 6px;
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-align: center;
  text-decoration: none;
}

.back-btn {
  background-color: #191b1b;
  display: inline-block;
  margin-bottom: 20px;
}

.back-btn:hover {
  background-color: #191b1b;
}

.submit-btn {
  background-color: #191b1b;
}

.submit-btn:hover {
  background-color: #191b1b;
}
</style>
