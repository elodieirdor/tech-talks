import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexTalksPage from './pages/IndexTalksPage';

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'index',
      component: IndexTalksPage
    }
  ]
});

export default router;