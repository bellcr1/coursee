<script src="https://js.stripe.com/v3/"></script>

<form id="payment-form">
  <div id="card-element"><!-- Stripe card element here --></div>
  <button id="submit">Payer</button>
</form>

<div id="payment-result"></div>

<script>
  const stripe = Stripe("pk_test_51RXBLMRjSelEp71V2WHMwbfjeyO474vOX1RxfbdOg4OINxDWpVPnZT8cbEIhcgC8xii7mh1r5LhmbQclaKP7wXTq00F6ner6uw");
  const elements = stripe.elements();

  const card = elements.create("card", {
    hidePostalCode: true
  });
  card.mount("#card-element");

  const form = document.getElementById("payment-form");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const { paymentMethod, error } = await stripe.createPaymentMethod({
      type: "card",
      card: card,
    });

    if (error) {
      document.getElementById("payment-result").textContent = "Erreur: " + error.message;
    } else {
      // ✅ نبعثوا paymentMethod.id لل API
      fetch("/api/payment", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}" // إذا تستعمل Blade
        },
        body: JSON.stringify({
          payment_method: paymentMethod.id
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          document.getElementById("payment-result").textContent = "✅ Paiement confirmé !";
          console.log(data);
        } else {
          document.getElementById("payment-result").textContent = "❌ Erreur paiement: " + data.error;
        }
      })
      .catch(err => {
        document.getElementById("payment-result").textContent = "❌ Erreur serveur: " + err.message;
      });
    }
  });
</script>
