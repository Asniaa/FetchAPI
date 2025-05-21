<script setup>
import axios from 'axios';
import { onMounted, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const postId = route.params.id;

const form = reactive({
    student_name: '',
    student_no: '',
    student_class: ''
});

const isLoading = reactive({ fetch: false, submit: false });

onMounted(async () => {
    if (!postId) {
        console.error("Post ID is missing.");
        return;
    }

    isLoading.fetch = true;
    try {
        const response = await axios.get(`http://localhost/belajar.api/get-post.php?id=${postId}`);
        form.student_name = response.data.student_name;
        form.student_no = response.data.student_no;
        form.student_class = response.data.student_class;
        console.log("Success fetching post");
    } catch (error) {
        console.error("Error fetching post", error);
    } finally {
        isLoading.fetch = false;
    }
});

const handleSubmit = async () => {
    if (!form.student_name.trim() || !form.student_no.trim() || !form.student_class.trim()) {
        alert("All fields are required.");
        return;
    }

    const updatePost = {
        student_id: postId,
        student_name: form.student_name,
        student_no: form.student_no,
        student_class: form.student_class
    };

    isLoading.submit = true;
    try {
        const response = await axios.patch(`http://localhost/belajar.api/update-data.php`, updatePost);
        router.push(`/posts/${response.data.student_id}`);
    } catch (error) {
        console.error("Error updating post", error);
    } finally {
        isLoading.submit = false;
    }
};
</script>

<template>
    <div class="form-container">
        <RouterLink to="/posts" class="btn back-btn">← Return to Posts</RouterLink>

        <div v-if="isLoading.fetch" class="loading-text">Loading post data...</div>

        <form v-else @submit.prevent="handleSubmit">
            <h2>✏️ Edit Student</h2>

            <label for="student_name">Name</label>
            <input 
                v-model="form.student_name" 
                type="text" 
                id="student_name" 
                placeholder="Student Name" 
                required>

            <label for="student_no">No</label>
            <input 
                v-model="form.student_no" 
                type="text" 
                id="student_no" 
                placeholder="Student Number" 
                required>

            <label for="student_class">Class</label>
            <input 
                v-model="form.student_class" 
                type="text" 
                id="student_class" 
                placeholder="Student Class" 
                required>

            <button :disabled="isLoading.submit" type="submit" class="btn submit-btn">
                {{ isLoading.submit ? 'Submitting...' : 'Submit' }}
            </button>
        </form>
    </div>
</template>

<style scoped>
.form-container {
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

.loading-text {
    text-align: center;
    color: #64748b;
    font-size: 1.1rem;
    margin: 20px 0;
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
