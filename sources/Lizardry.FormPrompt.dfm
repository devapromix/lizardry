object FormPrompt: TFormPrompt
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'Lizardry'
  ClientHeight = 203
  ClientWidth = 666
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
    Width = 666
    Height = 121
    Align = alTop
    Caption = 'lbMessage'
    TabOrder = 0
  end
end
