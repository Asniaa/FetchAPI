<template>
  <div class="login-container">
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="username">Username</label>
        <input
          type="text"
          id="username"
          v-model="username"
          placeholder="Enter your username"
          required
        />
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          v-model="password"
          placeholder="Enter your password"
          required
        />
      </div>
      
      <button type="submit" class="btn">Login</button>
      
      <div v-if="errorMessage" class="error">
        {{ errorMessage }}
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
      errorMessage: '', // For showing error messages
    };
  },
  methods: {
    async login() {
      try {
        const response = await fetch('http://localhost/belajar.api/login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
          // Handle successful login, redirect to dashboard or wherever
          this.$router.push('/posts'); // Ganti dengan rute yang sesuai
        } else {
          this.errorMessage = data.msg; // Menampilkan pesan error
        }
      } catch (error) {
        this.errorMessage = 'An error occurred while logging in.';
        console.error('Error:', error);
      }
    },
  },
};
</script>

<style scoped>
/* Add your CSS styles for the login form */
.login-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-size: 14px;
  color: #333;
}

input {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
