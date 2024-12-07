<template>
  <div id="app">
    <HelloComponent />
  </div>
</template>

<script>
import HelloComponent from './components/HelloComponent.vue';

export default {
  name: 'App',
  components: {
    HelloComponent,
  },
};
</script>

<style>
/* Estilos para la app (opcional) */
</style>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
