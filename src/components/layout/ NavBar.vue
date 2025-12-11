<script setup lang="ts">
import SearchButton from '../SearchButton.vue'
</script>
<template>
  <nav class="bg-white fixed w-full z-20 top-0 start-0">
    <div class="flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/Image/Logo.png" class="h-10" alt="Logo" />
      </a>
      <SearchButton />
      <button
        data-collapse-toggle="navbar-default"
        type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
        aria-controls="navbar-default"
        aria-expanded="false"
      >
        <span class="sr-only">Open main menu</span>
        <svg
          class="w-6 h-6"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          fill="none"
          viewBox="0 0 24 24"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-width="2"
            d="M5 7h14M5 12h14M5 17h14"
          />
        </svg>
      </button>

      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul
          class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary"
        >
          <li>
            <a
              href=""
              class="py-2 px-3 text-heading bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0 gap-2 flex items-center"
              aria-current="page"
            >
              <i class="pi pi-user" style="font-size: 20px"></i> Account</a
            >
          </li>
          <li>
            <a
              href="#"
              class="py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent flex items-center gap-2"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 26 26"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g clip-path="url(#clip0_1579_767)">
                  <path
                    d="M20.298 8.38689L21.7149 7.56036C18.6493 2.29393 12.0415 0.282044 6.56113 2.94647V0.930176H4.9212V5.84997H9.84099V4.21004H7.74598C12.3848 2.24227 17.7631 4.032 20.298 8.38689Z"
                    fill="#253D4E"
                  />
                  <path
                    d="M5.33116 21.1635C1.52924 18.0758 0.528575 12.686 2.96884 8.43935L1.54702 7.61938C-1.2363 12.4661 -0.183154 18.6069 4.05611 22.2492H2.0513V23.8891H6.97109V18.9693H5.33116V21.1635Z"
                    fill="#253D4E"
                  />
                  <path
                    d="M22.5208 11.2355L19.0425 14.7146L20.202 15.874L21.5959 14.4801C21.0492 19.5603 16.7683 23.4158 11.6588 23.43V25.0699C17.7465 25.0539 22.7966 20.3557 23.2514 14.2849L24.8405 15.874L25.9999 14.7146L22.5208 11.2355Z"
                    fill="#253D4E"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_1579_767">
                    <rect width="26" height="26" fill="white" />
                  </clipPath>
                </defs>
              </svg>
              Compare</a
            >
          </li>
          <li>
            <a
              href="#"
              class="py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent flex items-center gap-2"
            >
              <i class="pi pi-heart" style="font-size: 20px"></i> Wishlist</a
            >
          </li>
          <li>
            <a
              href="#"
              class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent"
            >
              <i class="pi pi-shopping-cart" style="font-size: 20px"></i> Cart</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
