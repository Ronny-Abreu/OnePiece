// Main JavaScript file for One Piece Characters App

document.addEventListener("DOMContentLoaded", () => {
    initializeTooltips()
  
    initializeFileUpload()
  
    initializeSearch()
  
    initializeConfirmations()
  
    initializeAnimations()
  })
  
  // Tooltip initialization
  function initializeTooltips() {
    const tooltipElements = document.querySelectorAll("[data-tooltip]")
    tooltipElements.forEach((element) => {
      element.addEventListener("mouseenter", showTooltip)
      element.addEventListener("mouseleave", hideTooltip)
    })
  }
  
  function showTooltip(event) {
    const text = event.target.getAttribute("data-tooltip")
    const tooltip = document.createElement("div")
    tooltip.className = "tooltip"
    tooltip.textContent = text
    document.body.appendChild(tooltip)
  
    const rect = event.target.getBoundingClientRect()
    tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px"
    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + "px"
  }
  
  function hideTooltip() {
    const tooltip = document.querySelector(".tooltip")
    if (tooltip) {
      tooltip.remove()
    }
  }
  
  // File upload drag and drop
  function initializeFileUpload() {
    const fileUploadAreas = document.querySelectorAll(".file-upload-area")
  
    fileUploadAreas.forEach((area) => {
      const input = area.querySelector('input[type="file"]')
  
      area.addEventListener("dragover", (e) => {
        e.preventDefault()
        area.classList.add("dragover")
      })
  
      area.addEventListener("dragleave", (e) => {
        e.preventDefault()
        area.classList.remove("dragover")
      })
  
      area.addEventListener("drop", (e) => {
        e.preventDefault()
        area.classList.remove("dragover")
  
        const files = e.dataTransfer.files
        if (files.length > 0) {
          input.files = files
          input.dispatchEvent(new Event("change"))
        }
      })
    })
  }
  
  // Search functionality
  function initializeSearch() {
    const searchInput = document.querySelector('input[name="q"]')
    if (searchInput) {
      let searchTimeout
  
      searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
          if (this.value.length >= 2 || this.value.length === 0) {
            performSearch(this.value)
          }
        }, 500)
      })
    }
  }
  
  function performSearch(query) {
    // For now, we'll just submit the form
    const form = document.querySelector('form[action*="search"]')
    if (form) {
      form.submit()
    }
  }
  
  function initializeConfirmations() {
    const deleteLinks = document.querySelectorAll('a[href*="delete"]')
  
    deleteLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault()
  
        const characterName = this.closest(".character-card")?.querySelector("h3")?.textContent || "este personaje"
  
        showConfirmDialog(
          "¿Eliminar personaje?",
          `¿Estás seguro de que quieres eliminar a ${characterName}? Esta acción no se puede deshacer.`,
          () => {
            window.location.href = this.href
          },
        )
      })
    })
  }
  
  function showConfirmDialog(title, message, onConfirm) {
    const dialog = document.createElement("div")
    dialog.className = "fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    dialog.innerHTML = `
          <div class="bg-white rounded-lg p-6 max-w-md mx-4">
              <h3 class="text-lg font-bold text-gray-900 mb-2">${title}</h3>
              <p class="text-gray-600 mb-6">${message}</p>
              <div class="flex space-x-3">
                  <button class="confirm-btn flex-1 bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition-colors">
                      Eliminar
                  </button>
                  <button class="cancel-btn flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition-colors">
                      Cancelar
                  </button>
              </div>
          </div>
      `
  
    document.body.appendChild(dialog)
  
    dialog.querySelector(".confirm-btn").addEventListener("click", () => {
      document.body.removeChild(dialog)
      onConfirm()
    })
  
    dialog.querySelector(".cancel-btn").addEventListener("click", () => {
      document.body.removeChild(dialog)
    })
  
    dialog.addEventListener("click", (e) => {
      if (e.target === dialog) {
        document.body.removeChild(dialog)
      }
    })
  }
  
  // Animations
  function initializeAnimations() {
    // Animate cards on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    }
  
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateY(0)"
        }
      })
    }, observerOptions)
  
    const animatedElements = document.querySelectorAll(".character-card, .stats-card")
    animatedElements.forEach((el) => {
      el.style.opacity = "0"
      el.style.transform = "translateY(20px)"
      el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
      observer.observe(el)
    })
  }
  
  function showNotification(message, type = "info") {
    const notification = document.createElement("div")
    notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${getNotificationClass(type)}`
    notification.textContent = message
  
    document.body.appendChild(notification)
  
    setTimeout(() => {
      notification.style.opacity = "0"
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification)
        }
      }, 300)
    }, 3000)
  }
  
  function getNotificationClass(type) {
    switch (type) {
      case "success":
        return "bg-green-500"
      case "error":
        return "bg-red-500"
      case "warning":
        return "bg-yellow-500"
      default:
        return "bg-blue-500"
    }
  }
  
  // Form validation
  function validateForm(form) {
    const requiredFields = form.querySelectorAll("[required]")
    let isValid = true
  
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        showFieldError(field, "Este campo es obligatorio")
        isValid = false
      } else {
        clearFieldError(field)
      }
    })
  
    return isValid
  }
  
  function showFieldError(field, message) {
    clearFieldError(field)
  
    const error = document.createElement("div")
    error.className = "field-error text-red-500 text-sm mt-1"
    error.textContent = message
  
    field.parentNode.appendChild(error)
    field.classList.add("border-red-500")
  }
  
  function clearFieldError(field) {
    const existingError = field.parentNode.querySelector(".field-error")
    if (existingError) {
      existingError.remove()
    }
    field.classList.remove("border-red-500")
  }
  
  function previewImage(input) {
    const preview = document.getElementById("image-preview")
  
    if (input.files && input.files[0]) {
      const reader = new FileReader()
  
      reader.onload = (e) => {
        preview.innerHTML = `
                  <img src="${e.target.result}" class="w-32 h-32 object-cover rounded-lg mx-auto mb-2">
                  <p class="text-sm text-gray-600">Imagen seleccionada</p>
                  <p class="text-xs text-gray-500">Haz clic para cambiar</p>
              `
      }
  
      reader.readAsDataURL(input.files[0])
    }
  }
  
  // Level display update
  function updateNivelDisplay(value) {
    const descriptions = {
      1: "Novato",
      2: "Principiante",
      3: "Intermedio",
      4: "Avanzado",
      5: "Legendario",
    }
  
    const numberElement = document.getElementById("nivel-number")
    const starsElement = document.getElementById("nivel-stars")
    const descriptionElement = document.getElementById("nivel-description")
  
    if (numberElement) numberElement.textContent = value
    if (starsElement) starsElement.textContent = "⭐".repeat(value)
    if (descriptionElement) descriptionElement.textContent = descriptions[value]
  }
  
  // Mobile menu toggle
  function toggleMobileMenu() {
    const menu = document.getElementById("mobile-menu")
    if (menu) {
      menu.classList.toggle("hidden")
    }
  }
  
  // Loading state management
  function showLoading(element) {
    const originalContent = element.innerHTML
    element.innerHTML = '<span class="loading"></span> Cargando...'
    element.disabled = true
  
    return function hideLoading() {
      element.innerHTML = originalContent
      element.disabled = false
    }
  }
  
  // functions for global use
  window.previewImage = previewImage
  window.updateNivelDisplay = updateNivelDisplay
  window.toggleMobileMenu = toggleMobileMenu
  window.showNotification = showNotification
  window.validateForm = validateForm
  