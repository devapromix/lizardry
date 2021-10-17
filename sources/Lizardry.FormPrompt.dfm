object FormPrompt: TFormPrompt
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  ClientHeight = 212
  ClientWidth = 600
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
    Left = 120
    Top = 144
    Width = 161
    Height = 33
    OnClick = bbOKClick
  end
  object lbMessage: TLabel
    Left = 0
    Top = 0
    Width = 600
    Height = 113
    Align = alTop
    Alignment = taCenter
    AutoSize = False
    Caption = 'lbMessage'
    WordWrap = True
  end
  object bbCancel: TSpeedButton
    Left = 312
    Top = 144
    Width = 161
    Height = 33
    Caption = #1054#1090#1084#1077#1085#1072
    OnClick = bbCancelClick
  end
end
