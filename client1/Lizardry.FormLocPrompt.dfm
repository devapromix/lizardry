object FormLocPrompt: TFormLocPrompt
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'FormLocPrompt'
  ClientHeight = 202
  ClientWidth = 664
  Color = clBtnFace
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 21
  object bbOK: TSpeedButton
    Left = 152
    Top = 144
    Width = 161
    Height = 33
    Caption = #1055#1086#1082#1080#1085#1091#1090#1100'!'
    OnClick = bbOKClick
  end
  object bbCancel: TSpeedButton
    Left = 368
    Top = 144
    Width = 161
    Height = 33
    Caption = #1054#1090#1084#1077#1085#1072
    OnClick = bbCancelClick
  end
  object lbMessage: TPanel
    Left = 0
    Top = 0
    Width = 664
    Height = 121
    Align = alTop
    Caption = #1045#1097#1077' '#1085#1077'  '#1074#1077#1089#1100' '#1083#1091#1090' '#1089#1086#1073#1088#1072#1085'! '#1055#1086#1082#1080#1085#1091#1090#1100' '#1083#1086#1082#1072#1094#1080#1102'?'
    TabOrder = 0
    ExplicitLeft = -73
    ExplicitWidth = 666
  end
end
