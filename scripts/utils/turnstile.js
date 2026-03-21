export function isTurnstileMisconfigured() {
  return Boolean(globalThis.faqTurnstileMustConfigureSiteKey);
}

export async function initTurnstile(siteKey, containerSelector) {
  const trimmed = (siteKey || '').trim();
  const el = document.querySelector(containerSelector);

  if (!trimmed.length) {
    if (el) {
      el.replaceChildren();
    }
    return {
      getToken: () => '',
      reset: () => {},
      isEnforced: false,
    };
  }

  if (!el) {
    return {
      getToken: () => '',
      reset: () => {},
      isEnforced: true,
    };
  }

  await new Promise((resolve) => {
    if (globalThis.turnstile?.ready) {
      globalThis.turnstile.ready(resolve);
    } else {
      const t = setInterval(() => {
        if (globalThis.turnstile?.ready) {
          clearInterval(t);
          globalThis.turnstile.ready(resolve);
        }
      }, 30);
    }
  });

  let widgetId = null;
  let lastToken = null;

  el.replaceChildren();

  const mount = document.createElement('div');
  mount.className = 'turnstile-widget-mount';
  el.appendChild(mount);

  widgetId = globalThis.turnstile.render(mount, {
    sitekey: trimmed,
    callback: (token) => {
      lastToken = token;
    },
    'expired-callback': () => {
      lastToken = null;
    },
    'error-callback': () => {
      lastToken = null;
    },
  });

  return {
    getToken: () => lastToken || '',
    reset: () => {
      lastToken = null;
      if (widgetId !== null) {
        globalThis.turnstile.reset(widgetId);
      }
    },
    isEnforced: true,
  };
}
