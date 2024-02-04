<template>
  <div class="d-flex flex-column justify-content-center align-content-center">
    <div class="createButton d-flex justify-content-end pe-0">
      <router-link
        class="btn btn-success"
        :to="{ name: 'tasks.create' }"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-plus-circle-fill"
          viewBox="0 0 16 16"
        >
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </svg>
        Criar
      </router-link>
    </div>
    <div class="row">
      <div
        class="col-md-3 mt-3"
        :key="task.id"
        v-for="task in tasks"
      >
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              {{ task.title }}
            </h5>
            <p
              class="card-text text-truncate"
            >
              {{ task.description }}
            </p>
            <div class="d-flex justify-content-between">
              <router-link
                class="btn btn-primary"
                :to="{name: 'tasks.find', params: {id: task.id}}"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-plus-circle-fill"
                  viewBox="0 0 16 16"
                >
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
                Acessar
              </router-link>
              <a
                class="btn btn-danger"
                @click.prevent="deleteTask(task)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-x-circle"
                  viewBox="0 0 16 16"
                >
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
                Remover
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
import { getTasks, deleteTask } from '@/services/taskService';

export default {
  name: 'IndexTaskView',
  data() {
    return {
      tasks: [],
    };
  },
  async created() {
    try {
      const response = await getTasks();

      if (response.ok) {
        this.tasks = (await response.json()).data;
      }

      if (response.status == 500) {
        location.reload();
      }

    } catch (error) {
      location.reload();
    }
  },

  methods: {
    async deleteTask(task) {
      const indexRemove = this.tasks.indexOf(task);
      const response = await deleteTask(task);

      if (response.ok) {
        this.tasks.splice(indexRemove, 1);
      }
    },
  }, 
};
</script>