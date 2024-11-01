<?php

  echo '
    <style>
      .wpdn-error {
        color: #CC0000 !important;
      }

      .wpdn-muted {
        color: #CCC !important;
      }

      .wpdn-success {
        color: #28a745 !important;
      }

      #form_'. $this->id .' {
        align-content: center !important;
        align-items: stretch !important;
        display: flex !important;
        font-size: 14px !important;
      }

      #form_'. $this->id .' button,
      #form_'. $this->id .' a {
        border-radius: 3px !important;
        border: none !important;
        color: #FFF !important;
        cursor: pointer !important;
        font-weight: 600 !important;
        padding: 8px 10px !important;
        text-decoration: none !important;
        white-space: nowrap !important;
      }

      #search_'. $this->id .' {
        background-color: #3b8dbd !important;
      }

      #buy_'. $this->id .' {
        background-color: #28a745 !important;
      }

      #domain_'. $this->id .' {
        background-color: #FFF !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 3px !important;
        border-bottom: 1px solid #CCC !important;
        border-left: 0 !important;
        border-right: 1px solid #CCC !important;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 3px !important;
        border-top: 1px solid #CCC !important;
        box-sizing: border-box !important;
        -moz-box-sizing: border-box !important;
        -webkit-box-sizing: border-box !important;
        -ms-box-sizing: border-box !important;
        flex-grow: 1 !important;
        font-size: 14px !important;
        margin-left: -1px !important;
        margin-right: 10px !important;
        padding: 10px !important;
      }

      #domain_'. $this->id .':focus {
        box-shadow: 0 0 0 0 #CCC !important;
      }

      #icon_'. $this->id .' {
        align-items: center !important;
        background-color: #FFF !important;
        border-bottom-left-radius: 3px !important;
        border-bottom: 1px solid #CCC !important;
        border-left: 1px solid #CCC !important;
        border-right: 0 !important;
        border-top-left-radius: 3px !important;
        border-top: 1px solid #CCC !important;
        color: #CCC !important;
        display: flex !important;
        padding: 10px 0 10px 10px !important;
      }

      #error_'. $this->id .' {
        color: #CC0000 !important;
        font-size: 80% !important;
      }
    </style>
  ';

?>