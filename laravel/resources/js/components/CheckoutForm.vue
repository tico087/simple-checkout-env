<template>
  <div class="row">
    <div class="overflow-loading" v-if="loading">
      <div
        class="spinner-border"
        style="width: 3rem; height: 3rem"
        role="status"
      >
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Produtos</span>
      </h4>
      <ul class="list-group mb-3">
        <li
          class="list-group-item d-flex justify-content-between lh-condensed"
          v-for="(product, index) in products.items"
          :key="index"
        >
          <div>
            <h6 class="my-0">{{ product.name }}</h6>
            <small class="text-muted">SKU : {{ product.id }}</small>
          </div>
          <span class="text-muted">{{ currency(product.price) }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span>Total (BRL)</span>
          <strong>{{ total }}</strong>
        </li>
      </ul>
    </div>
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Informações</h4>
      <form v-on:submit.prevent="submitHandler">
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <label>Nome</label>
            <input
              type="text"
              class="form-control"
              v-model="form.info.firstName"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Sobrenome</label>
            <input
              type="text"
              class="form-control"
              v-model="form.info.lastName"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>CPF/CNPJ</label>
            <MaskInput
              type="text"
              class="form-control"
              :value="form.info.docNumber"
              v-model="form.info.docNumber"
              mask="###.###.###-##"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Email</label>
            <input
              type="email"
              class="form-control"
              v-model="form.info.email"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Telefone </label>
            <MaskInput
              type="text"
              class="form-control"
              :value="form.info.phone"
              v-model="form.info.phone"
              mask="(##) #####-####"
            />
          </div>
        </div>
        <h4 class="mb-3">Endereço</h4>
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <label>CEP</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.zipCode"
              @change="getAddress"
            />
          </div>
          <div class="col-md-8 mb-3">
            <label>Endereço</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.address"
            />
          </div>
          <div class="col-md-4 mb-3">
            <label>Número</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.number"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Bairro</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.neighborhood"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Cidade</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.city"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Estado</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.state"
            />
          </div>
          <div class="col-md-6 mb-3">
            <label>Complemento</label>
            <input
              type="text"
              class="form-control"
              v-model="form.address.complement"
            />
          </div>
        </div>
        <h4 class="mb-3">Pagamento</h4>
        <div class="row d-block mt-3 mb-4">
          <div class="col-12">
            <div class="form-check">
              <input
                class="form-check-input"
                v-model="form.payment.billingType"
                id="pmCreditCard"
                name="paymentMethod"
                type="radio"
                value="CREDIT_CARD"
              />
              <label class="form-check-label" for="pmCreditCard">
                Cartão de Crédito
              </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                v-model="form.payment.billingType"
                id="pmBankslip"
                name="paymentMethod"
                type="radio"
                value="BOLETO"
              />
              <label class="form-check-label" for="pmBankslip"> Boleto </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                v-model="form.payment.billingType"
                id="pmPix"
                name="paymentMethod"
                type="radio"
                value="PIX"
              />
              <label class="form-check-label" for="pmPix"> PIX </label>
            </div>
          </div>
        </div>
        <template v-if="form.payment.billingType === 'CREDIT_CARD'">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Nome impresso no cartão</label>
              <input
                type="text"
                class="form-control uppercase"
                v-model="form.payment.holderName"
              />
            </div>
            <div class="col-md-6 mb-3">
              <label>Número do cartão</label>
              <MaskInput
                type="text"
                class="form-control"
                :value="form.payment.number"
                v-model="form.payment.number"
                mask="#### #### #### ####"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <label>Validade </label>
              <MaskInput
                type="text"
                class="form-control"
                :value="form.payment.expiryDate"
                v-model="form.payment.expiryDate"
                mask="##/####"
              />
            </div>
            <div class="col-md-3 mb-3">
              <label>CVV</label>
              <input
                type="text"
                class="form-control"
                v-model="form.payment.cvv"
              />
            </div>
            <!-- parcelas -->
            <div class="col-md-6 mb-3">
              <label>Parcelas</label>
              <select class="form-select" v-model="form.payment.installments">
                <option value="1">1x sem juros</option>
                <option value="2">2x sem juros</option>
                <option value="3">3x sem juros</option>
                <option value="4">4x sem juros</option>
              </select>
            </div>
          </div>
        </template>
        <template
          v-else-if="['BOLETO', 'PIX'].includes(form.payment.billingType)"
        >
          <div class="row">
            <div class="col-12 mb-3">
              <div class="bg-light p-3 rounded text-center">
                <template v-if="form.payment.billingType === 'BOLETO'">
                  <img src="./bankslip.png" class="my-3" width="100px" /><br />
                  <strong
                    >Você terá acesso ao boleto assim que finalizar a
                    compra</strong
                  >, porém a mesma será considerada finalizada
                  <strong>apenas após a compensação do pagamento</strong>.
                </template>
                <template v-else>
                  <img src="./pix.png" class="my-3" width="200px" /><br />
                  <strong
                    >Você terá acesso ao QR code assim que finalizar a
                    compra</strong
                  >
                  e a mesma será considerada finalizada
                  <strong>imediatamente após a confirmação do pagamento</strong
                  >.
                </template>
              </div>
            </div>
          </div>
        </template>
        <hr class="mb-4" />
        <button
          class="btn btn-primary btn-lg btn-block"
          type="submit"
          :disabled="loading"
        >
          Finalizar compra
        </button>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: ["products", "submit_route", "env"],
  data() {
    return {
      loading: false,
      form: {
        info: {
          firstName: "",
          lastName: "",
          email: "",
          docNumber: "",
          phone: "",
        },
        payment: {
          billingType: "CREDIT_CARD",
          holderName: "",
          number: "",
          expiryDate: "",
          cvv: "",
          installments: 1,
        },
        address: {
          number: "",
          zipCode: "",
          address: "",
          neighborhood: "",
          city: "",
          state: "",
          complement: "",
        },
      },
    };
  },
  computed: {
    rawTotal() {
      return this.products.items.reduce((total, product) => {
        return total + product.price;
      }, 0);
    },
    total() {
      return this.currency(this.rawTotal);
    },
  },
  mounted() {
    if (this.env === "local") {
      window.test = (type = null) => {
        this.form = {
          ...this.form,
          ...{
            info: {
              firstName: "Walter",
              lastName: "Heisenberg White",
              email: "walter@meta.com.br",
              docNumber: "705.749.580-37",
              phone: "(11) 958935182",
            },
            payment: {
              billingType: "CREDIT_CARD",
              holderName: "WALTER H WHITE",
              number:
                type === "error" ? "5184019740373151" : "5365772007861000",
              expiryDate: "04/2026",
              cvv: "318",
              installments: 1,
            },
            address: {
              number: "308",
              zipCode: "89223005",
              address: "Alameda Negra Arroyo",
              neighborhood: "Los Ranchos de Albuquerque",
              city: "Albuquerque",
              state: "NM",
              complement: "",
            },
          },
        };
      };
    }
  },
  methods: {
    getAddress() {
      const onlyNumbers = this.form.address.zipCode.replace(/\D/g, "");
      fetch(`https://viacep.com.br/ws/${onlyNumbers}/json/`)
        .then((response) => {
          if (!response.ok) {
            throw new Error("Erro ao buscar o endereço");
          }
          return response.json();
        })
        .then((data) => {
          this.form.address.address = `${data.logradouro}`;
          this.form.address.neighborhood = `${data.bairro}`;
          this.form.address.city = `${data.localidade}`;
          this.form.address.state = `${data.uf}`;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    currency(value) {
      return Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(Number(value).toFixed(2));
    },
    submitHandler() {
      this.loading = true;
      let payload = this.form;
      payload.payment = {
        ...payload.payment,
        total: this.rawTotal,
      };

      this.$http
        .post(this.submit_route, payload)
        .then(({ data }) => {
          if (!data.success) {
            this.loading = false;
            return this.$toast("Erro", data.error, "error");
          }
          if (data.redirect) {
            window.location.href = data.redirect;
          }
        })
        .catch((error) => {
          if (error?.response?.status === 422) {
            const validationErrors = error?.response?.data?.errors || {};
            const errorKeys = Object.keys(validationErrors);
            const htmlListOfErrors = errorKeys.map((key) => {
              return `<li>${validationErrors[key].join(", ")}</li>`;
            });
            this.$toast(
              "Erro",
              `<ul>${htmlListOfErrors.join("")}</ul>`,
              "error"
            );
          } else {
            this.$toast(
              "Erro",
              "Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte.",
              "error"
            );
          }
          this.loading = false;
        });
    },
  },
};
</script>
