<template>
  <div class="d-flex vh-100 flex-column justify-content-center align-content-center">
    <h2 class="text-center">
      Criar Task
    </h2>
    <div class="d-flex justify-content-center align-content-center">
      <form
        class="row g-3"
        @submit.prevent="submitForm"
      >
        <input
          class="form-control"
          v-model="title"
          type="text"
          placeholder="Titulo"
        >
        <span v-if="validateTitle">{{ validateTitle }}</span>
        <textarea
          class="form-control"
          v-model="description"
          type="text"
          placeholder="Descrição"
        />
        <span v-if="validateDescription">{{ validateDescription }}</span>
        <button
          class="btn btn-primary mb-3"
          type="submit"
        >
          Salvar
        </button>
      </form>
    </div>
  </div>
</template>
 
<script> 
import { createTask } from '@/services/taskService';

export default {
  name: 'CreateTaskView',
  data() {
    return {
      title: '',
      validateTitle: '',
      description: '',
      validateDescription: '',
    };
  },

  methods: {
    async submitForm() {
      if(this.validateForm()) {
        const task = {title: this.title, description: this.description};
        const response = await createTask(task);
        
        if (response.ok) {
          this.$router.push({name: 'tasks.index'});
        }
      }
    },

    validateForm() {
      if (!this.title) {
        this.validateTitle = 'Titulo obrigatório';
        return false;
      }
      if (!this.description) {
        this.validateTitle = '';
        this.validateDescription = 'Descrição obrigatória';
        return false;
      }
      return true;
    }
  },

};
</script>
