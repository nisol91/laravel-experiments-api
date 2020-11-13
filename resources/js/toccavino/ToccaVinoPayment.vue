<template>
  <div class="d-flex justify-content-center">
    <div class="paymentBox">
      <div class="titleBox">
        <router-link class="btn nav-button" :to="{ name: 'toccaVinoHome' }">
          <i class="fas fa-angle-left freccia"></i>
        </router-link>

        <div class="title">Credit card</div>
      </div>
      <transition name="rotate" v-on:leave="leave">
        <div v-if="rotation" class="creditCardContainer">
          <div v-if="front" class="front">
            <div class="row masterIcon">
              <i class="fab fa-cc-mastercard"></i>
            </div>
            <div class="row cardCode d-flex justify-content-center">
              {{ card.number ? card.numberChanged : card.placeholder }}
            </div>
            <div class="row d-flex justify-content-between">
              <div class="name">
                <div>name</div>
                <div class="font-weight-bolder">{{ card.name }}</div>
              </div>
              <div class="expiry">
                <div>expiry</div>
                <div class="font-weight-bolder">{{ card.expiry }}</div>
              </div>
            </div>
          </div>
          <div v-if="!front" class="back">
            <div class="blackBelt"></div>
            <div class="cvvBox">
              <div class="cvv">{{ card.cvv }}</div>
            </div>
          </div>
        </div>
      </transition>
      <div class="form">
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="number">Card Number</label>
            <input
              @focus="rotateBack"
              @keyup="subStr(card.number)"
              type="text"
              class="form-control"
              name="number"
              v-model="card.number"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="name">Card Name</label>
            <input
              @focus="rotateBack"
              type="text"
              class="form-control"
              name="name"
              v-model="card.name"
            />
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="expiry">Expiry Date</label>
            <input
              @focus="rotateBack"
              type="text"
              class="form-control"
              name="expiry"
              v-model="card.expiry"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="cvv">cvv</label>
            <input
              @focus="rotate"
              type="text"
              class="form-control"
              name="cvv"
              v-model="card.cvv"
            />
          </div>
        </div>
      </div>
      <div class="mt-4 row j-flex justify-content-center align-items-center">
        <div class="btn btn-secondary btn-block">pay</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      front: true,
      rotation: true,
      card: {
        number: "",
        numberChanged: "",
        placeholder: "**** **** **** ****",
        name: "",
        expiry: "",
        cvv: "",
      },
    };
  },
  methods: {
    subStr(str) {
      const chars = str.split("");

      const placeholder = [
        "*",
        "*",
        "*",
        "*",
        " ",
        "*",
        "*",
        "*",
        "*",
        " ",
        "*",
        "*",
        "*",
        "*",
        " ",
        "*",
        "*",
        "*",
        "*",
      ];
      for (let i = 0; i < chars.length; i++) {
        if (i === 4 || i === 9 || i === 14) {
          chars.splice(i, 0, " ");
        }
      }

      //   console.log(chars);

      for (let i = 0; i < placeholder.length; i++) {
        if (chars[i]) {
          placeholder[i] = chars[i];
        }
      }
      //  console.log(placeholder);
      const finalStr = placeholder.join("");

      this.card.numberChanged = finalStr;
    },
    rotate() {
      this.rotation = !this.rotation;
      setTimeout(() => {
        this.front = !this.front;
      }, 100);
    },
    rotateBack() {
      if (!this.front) {
        this.rotation = !this.rotation;
        setTimeout(() => {
          this.front = !this.front;
        }, 100);
      }
    },
    leave() {
      this.rotation = true;
    },
  },
};
</script>

<style scoped>
.paymentBox {
  width: 50%;
  background: rgba(147, 158, 165, 0.584);
  height: 100vh;
  border-radius: 10px;
}

.titleBox {
  height: auto;
  padding: 20px;
  display: flex;
  justify-content: center;
  position: relative;
}
.freccia {
  position: absolute;
  top: 25px;
  left: 20px;
  cursor: pointer;
}
.title {
  color: rgb(20, 20, 46);
}
.creditCardContainer {
  width: 350px;
  margin: 20px auto;
  padding: 30px;
  height: 200px;
  background: rgb(131, 101, 101);
  border-radius: 10px;
  box-shadow: 0px 0px 5px 1px rgba(189, 189, 189, 1);
  position: relative;
}
.form {
  background: white;
  border-radius: 10px;
  width: 100%;
  height: 200px;
  padding: 20px;
}
.masterIcon {
  font-size: 35px;
}
.cardCode {
  font-size: 20px;
  margin: 20px;
}
.back {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: flex-start;
  align-items: flex-end;
}
.cvvBox {
  background: rgb(157, 157, 109);
  width: 80%;
  height: 40px;
  display: flex;
  justify-content: flex-end;
  padding: 10px;
}
.cvv {
  font-size: 18px;
  color: black;
}
.blackBelt {
  height: 40px;
  width: 100%;
  background: black;
  position: absolute;
  left: 0;
  top: 30px;
}

@keyframes rotate {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(360deg);
  }
}

.rotate-enter,
.rotate-enter-active {
  animation: rotate 1s;
}

.rotate-leave,
.rotate-leave-active {
  animation: rotate 1s reverse;
}
</style>
