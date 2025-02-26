gsap.from(".hero-image-wrapper, .content-wrapper, .front-img", 2, {
    delay: 1,
    clipPath: "inset(0 100% 0 0)",
    ease: "power4.inOut",
    stagger: {
      amount: 0.5,
    },
  });

  gsap.from("img", 3, {
    delay: 1.5,
    scale: 2,
    ease: "power4.inOut",
    stagger: {
      amount: 0.25,
    },
  });

  gsap.to(
    "header h1, header h2",
    1,
    {
      delay: 3,
      top: 0,
      ease: "power3.out",
      stagger: {
        amount: 0.2,
      },
    },
    "-=1"
  );

  document.getElementById("download-invoice").addEventListener("click", function(event) {
    event.preventDefault();
    let transactionId = document.getElementById("transaction-id").value;
    
    if (!transactionId) {
        alert("Silakan masukkan Transaction ID!");
        return;
    }

    // Mengambil data transaksi dari server
    fetch(`/transaksi/${transactionId}/status`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Memperbarui elemen footer dengan data transaksi
                document.getElementById('transaction-id-placeholder').textContent = data.id_transaksi;
                document.getElementById('transaction-status-placeholder').textContent = `Masih dalam status ${data.status}`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});