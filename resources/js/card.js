import ContextSelector from './components/ContextSelector';

Nova.booting((app) => {
  app.component('laravel-nova-context-selector', ContextSelector);
});
