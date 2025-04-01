import React, { useState, useEffect } from "react";
import styles from "./module_Login.module.scss";
import commonStyles from "../common.module.scss";
import { ButtonSimple, InputBox } from "components";
import pic from "assets/pictures/nlp_applications.png";
import $ from "jquery";

const Module_Login = () => {
  const [username, setUsername] = useState(null);
  const [password, setPassword] = useState(null);
  const [usernameError, setUsernameError] = useState("");
  const [passwordError, setPasswordError] = useState("");

  useEffect(() => {
    console.log(username, password);
  }, [username, password])
  function handleRegistration() {
    $.ajax({
      url: "http://localhost:8000/register.php",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({ username, password }),
      success: function (data) {
        alert(data.message  data.error);
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      }
    });
  }
  
  function handleLogin() {
    $.ajax({
      url: "http://localhost:8000/login.php",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({ username, password }),
      success: function (data) {
        alert(data.message  data.error);
        if (data.message) {
          window.location.href = "/dashboard";
          localStorage.setItem("username", JSON.stringify(username));
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      }
    });
  }
  
  const handleUsernameChange = (text) => {
    if (/^[a-zA-Z0-9]{3,15}$/.test(text)  text === "") {
      setUsername(text);
      setUsernameError("");
    } else {
      setUsernameError("Username must be 3-15 letters or numbers.");
    }
  };

  const handlePasswordChange = (text) => {
    if (/^[a-zA-Z0-9!@#$%^&*]{8,}$/.test(text)  text === "") {
      setPassword(text);
      setPasswordError("");
    } else {
      setPasswordError("Password must be at least 8 characters.");
    }
  };

  return (
    <div className={${commonStyles.moduleGroup} ${styles.module_Login} ${styles.global}}>
      <InputBox 
        placeholderText="Numele"
        onInputChange={handleUsernameChange}
        inlineContainer={usernameError ? { borderColor: "red", borderWidth: 2 } : null}
      />

      <InputBox 
        placeholderText="Parola"
        onInputChange={handlePasswordChange}
        inlineContainer={passwordError ? { borderColor: "red", borderWidth: 2 } : null}
      />

      <ButtonSimple 
        text={"Inregistrare"}
        onClick={handleRegistration}
      />
      <ButtonSimple 
        text={"Logare"}
        onClick={handleLogin}
      />
    </div>
  );
};

export default Module_Login;