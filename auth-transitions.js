(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  document.addEventListener('click', (event) => {
    if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
      return;
    }

    const clickedElement = event.target instanceof Element ? event.target : null;
    const link = clickedElement?.closest('a[href]');
    if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) {
      return;
    }

    const destination = new URL(link.href, window.location.href);
    if (destination.origin !== window.location.origin || !/\/(login|register)\.php$/.test(destination.pathname) || destination.pathname === window.location.pathname) {
      return;
    }

    event.preventDefault();
    document.body.classList.add('auth-page--leaving');
    const duration = reduceMotion.matches ? 150 : 340;
    window.setTimeout(() => window.location.assign(destination.href), duration);
  });

  document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || form.id !== 'loginForm' || event.defaultPrevented) {
      return;
    }

    event.preventDefault();
    document.body.classList.add('auth-page--leaving');
    const duration = reduceMotion.matches ? 150 : 340;
    window.setTimeout(() => HTMLFormElement.prototype.submit.call(form), duration);
  });
})();
