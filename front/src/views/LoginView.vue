<template>
  <div class="d-flex vh-100 flex-column justify-content-center align-content-center">
    <h2 class="text-center">
      Jukebox
    </h2>
    <div class="d-flex justify-content-center align-content-center">
      <form
        class="row g-3"
        @submit.prevent="submitForm"
      >
        <input
          class="form-control"
          v-model="email"
          type="text"
          id="email"
          placeholder="E-mail"
        >
        <span v-if="validateEmail">{{ validateEmail }}</span>
        <input
          class="form-control"
          v-model="password"
          type="password"
          placeholder="Senha"
        >
        <span v-if="validatePassword">{{ validatePassword }}</span>
        <span v-if="validateLogin">{{ validateLogin }}</span>
        <button
          class="btn btn-primary mb-3"
          type="submit"
        >
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>, validatePassword

<script>
import { loginFirebase } from '@/services/loginService';

export default {
  name: 'LoginView',
  data() {
    return {
      email: '',
      validateEmail: '',
      password: '',
      validatePassword: '',
      validateLogin: '',
    };
  },

  methods: {
    async submitForm() {

      if(this.validateForm()) {

        try {
          const response = await loginFirebase(this.email, this.password);

          if (response.ok) {
            localStorage.access_token = (await response.json()).access_token;
            this.$router.push({name: 'tasks.index'});
          }

        } catch (error) {
          this.validatePassword = '';
          this.validateLogin = 'Usuário ou senha inválidos';
        }       
      }     
    },

    validarEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return  regex.test(email);
    },

    validateForm() {
      if (!this.email) {
        this.validateEmail = 'E-mail obrigatório';
        return false;
      }
      if(!this.validarEmail(this.email)) {
        this.validateEmail = 'Endereço de e-mail inválido';
        return false;
      }
      if (!this.password) {
        this.validatePassword = 'Senha obrigatória';
        return false;
      }
      return true;
    }
  },
};
</script>